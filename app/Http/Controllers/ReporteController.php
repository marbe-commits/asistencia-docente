<?php

namespace App\Http\Controllers;

use App\Models\Asistencia;
use App\Models\Clase;
use App\Models\Docente;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ReporteController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | REPORTE GENERAL DE ASISTENCIAS
    |--------------------------------------------------------------------------
    |
    | Si se recibe docente_id:
    |   - Solo descarga las asistencias de ese profesor.
    |
    | Si NO se recibe docente_id:
    |   - Descarga todas las asistencias.
    |
    */

    public function asistenciasPdf(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | VALIDAR PROFESOR
        |--------------------------------------------------------------------------
        */

        $request->validate([
            'docente_id' => [
                'nullable',
                'integer',
                'exists:docentes,id'
            ]
        ], [
            'docente_id.exists' =>
                'El profesor seleccionado no existe.'
        ]);


        /*
        |--------------------------------------------------------------------------
        | OBTENER ASISTENCIAS
        |--------------------------------------------------------------------------
        */

        $query = Asistencia::with([
            'alumno',
            'docente',
            'clase.horario.materia',
            'clase.horario.grupo',
            'clase.horario.docente'
        ]);


        /*
        |--------------------------------------------------------------------------
        | FILTRO POR PROFESOR
        |--------------------------------------------------------------------------
        */

        if ($request->filled('docente_id')) {

            $query->where(
                'docente_id',
                $request->docente_id
            );
        }


        /*
        |--------------------------------------------------------------------------
        | ORDENAR ASISTENCIAS
        |--------------------------------------------------------------------------
        */

        $asistencias = $query
            ->orderBy('fecha_hora', 'DESC')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | OBTENER PROFESOR SELECCIONADO
        |--------------------------------------------------------------------------
        */

        $docente = null;

        if ($request->filled('docente_id')) {

            $docente = Docente::find(
                $request->docente_id
            );
        }


        /*
        |--------------------------------------------------------------------------
        | GENERAR PDF
        |--------------------------------------------------------------------------
        */

        $pdf = Pdf::loadView(
            'reportes.asistencias_pdf',
            [
                'asistencias' => $asistencias,
                'docente'     => $docente
            ]
        );


        /*
        |--------------------------------------------------------------------------
        | FORMATO DEL PDF
        |--------------------------------------------------------------------------
        */

        $pdf->setPaper(
            'letter',
            'landscape'
        );


        /*
        |--------------------------------------------------------------------------
        | NOMBRE DEL ARCHIVO
        |--------------------------------------------------------------------------
        */

        if ($docente) {

            $nombreDocente = trim(
                $docente->nombre . ' ' .
                $docente->apellido_paterno . ' ' .
                $docente->apellido_materno
            );

            $nombreDocente = preg_replace(
                '/[^A-Za-z0-9_-]/',
                '_',
                $nombreDocente
            );

            $nombreArchivo =
                'asistencias_' .
                $nombreDocente .
                '.pdf';

        } else {

            $nombreArchivo =
                'reporte_asistencias_general.pdf';
        }


        /*
        |--------------------------------------------------------------------------
        | DESCARGAR PDF
        |--------------------------------------------------------------------------
        */

        return $pdf->download(
            $nombreArchivo
        );
    }


    /*
    |--------------------------------------------------------------------------
    | FORMULARIO LISTA DE ASISTENCIA
    |--------------------------------------------------------------------------
    */

    public function formularioAsistencias(Clase $clase)
    {
        $clase->load([
            'horario.docente',
            'horario.materia',
            'horario.grupo',
            'horario.aula'
        ]);

        return view(
            'reportes.formulario_asistencias',
            compact('clase')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | DESCARGAR LISTA DE ASISTENCIA
    |--------------------------------------------------------------------------
    */

    public function descargarAsistencias(
        Request $request,
        Clase $clase
    ) {
        /*
        |--------------------------------------------------------------------------
        | VALIDAR FECHAS
        |--------------------------------------------------------------------------
        */

        $request->validate([
            'fecha_inicio' => [
                'required',
                'date'
            ],

            'fecha_fin' => [
                'required',
                'date',
                'after_or_equal:fecha_inicio'
            ]
        ], [

            'fecha_inicio.required' =>
                'Debes seleccionar la fecha inicial.',

            'fecha_fin.required' =>
                'Debes seleccionar la fecha final.',

            'fecha_fin.after_or_equal' =>
                'La fecha final debe ser igual o posterior a la fecha inicial.'
        ]);


        /*
        |--------------------------------------------------------------------------
        | CARGAR INFORMACIÓN DE LA CLASE
        |--------------------------------------------------------------------------
        */

        $clase->load([
            'horario.docente',
            'horario.materia',
            'horario.grupo',
            'horario.aula'
        ]);


        /*
        |--------------------------------------------------------------------------
        | OBTENER ASISTENCIAS
        |--------------------------------------------------------------------------
        */

        $asistencias = Asistencia::with([
            'alumno',
            'docente',
            'clase.horario.materia',
            'clase.horario.grupo',
            'clase.horario.docente'
        ])

        ->where(
            'clase_id',
            $clase->id
        )

        ->whereDate(
            'fecha_hora',
            '>=',
            $request->fecha_inicio
        )

        ->whereDate(
            'fecha_hora',
            '<=',
            $request->fecha_fin
        )

        ->orderBy(
            'fecha_hora',
            'ASC'
        )

        ->get();


        /*
        |--------------------------------------------------------------------------
        | GENERAR PDF
        |--------------------------------------------------------------------------
        */

        $pdf = Pdf::loadView(
            'reportes.lista_asistencia_pdf',
            [
                'clase'       => $clase,
                'asistencias' => $asistencias,
                'fechaInicio' => $request->fecha_inicio,
                'fechaFin'    => $request->fecha_fin
            ]
        );


        /*
        |--------------------------------------------------------------------------
        | FORMATO
        |--------------------------------------------------------------------------
        */

        $pdf->setPaper(
            'letter',
            'landscape'
        );


        /*
        |--------------------------------------------------------------------------
        | NOMBRE DEL ARCHIVO
        |--------------------------------------------------------------------------
        */

        $grupo =
            $clase->horario->grupo->nombre
            ?? 'grupo';

        $materia =
            $clase->horario->materia->nombre
            ?? 'materia';


        $nombreArchivo =
            'asistencia_' .
            $grupo .
            '_' .
            str_replace(
                ' ',
                '_',
                $materia
            ) .
            '.pdf';


        /*
        |--------------------------------------------------------------------------
        | DESCARGAR
        |--------------------------------------------------------------------------
        */

        return $pdf->download(
            $nombreArchivo
        );
    }
}