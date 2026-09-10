<?php

namespace App\Http\Controllers;

use App\Models\Aula;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class AulaController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | LISTAR AULAS
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $aulas = Aula::orderBy('id', 'desc')->get();

        return view('aulas.index', compact('aulas'));
    }


    /*
    |--------------------------------------------------------------------------
    | FORMULARIO CREAR
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        return view('aulas.create');
    }


    /*
    |--------------------------------------------------------------------------
    | GUARDAR AULA
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'edificio' => 'required|string|max:100',
            'capacidad' => 'required|integer|min:1'
        ]);

        Aula::create([
            'nombre' => $request->nombre,
            'edificio' => $request->edificio,
            'capacidad' => $request->capacidad,
            'activa' => true
        ]);

        return redirect()
            ->route('aulas.index')
            ->with('success', 'Aula registrada correctamente.');
    }


    /*
    |--------------------------------------------------------------------------
    | MOSTRAR AULA
    |--------------------------------------------------------------------------
    */

    public function show(Aula $aula)
    {
        return view('aulas.show', compact('aula'));
    }


    /*
    |--------------------------------------------------------------------------
    | FORMULARIO EDITAR
    |--------------------------------------------------------------------------
    */

    public function edit(Aula $aula)
    {
        return view('aulas.edit', compact('aula'));
    }


    /*
    |--------------------------------------------------------------------------
    | ACTUALIZAR AULA
    |--------------------------------------------------------------------------
    */

    public function update(Request $request, Aula $aula)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'edificio' => 'required|string|max:100',
            'capacidad' => 'required|integer|min:1'
        ]);

        $aula->update([
            'nombre' => $request->nombre,
            'edificio' => $request->edificio,
            'capacidad' => $request->capacidad
        ]);

        return redirect()
            ->route('aulas.index')
            ->with('success', 'Aula actualizada correctamente.');
    }


    /*
    |--------------------------------------------------------------------------
    | ELIMINAR AULA
    |--------------------------------------------------------------------------
    */

    public function destroy(Aula $aula)
    {
        $aula->delete();

        return redirect()
            ->route('aulas.index')
            ->with('success', 'Aula eliminada correctamente.');
    }


    /*
    |--------------------------------------------------------------------------
    | DESCARGAR PLANTILLA CSV
    |--------------------------------------------------------------------------
    */

    public function descargarPlantilla()
    {
        $contenido = "\xEF\xBB\xBF";

        $contenido .= "nombre,edificio,capacidad,activa\n";

        $contenido .= "Aula 101,Edificio A,30,1\n";
        $contenido .= "Laboratorio 1,Edificio B,25,1\n";

        return Response::make(
            $contenido,
            200,
            [
                'Content-Type' => 'text/csv; charset=UTF-8',
                'Content-Disposition' => 'attachment; filename="plantilla_aulas.csv"',
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | IMPORTAR AULAS
    |--------------------------------------------------------------------------
    */

    public function importar(Request $request)
    {
        $request->validate([
            'archivo' => 'required|file|mimes:csv,txt|max:2048',
        ], [
            'archivo.required' => 'Selecciona un archivo.',
            'archivo.file' => 'El archivo no es válido.',
            'archivo.mimes' => 'El archivo debe ser CSV.',
            'archivo.max' => 'El archivo no puede superar los 2 MB.',
        ]);

        $archivo = $request->file('archivo');

        $contenido = file_get_contents(
            $archivo->getRealPath()
        );

        /*
        |--------------------------------------------------------------------------
        | QUITAR BOM UTF-8
        |--------------------------------------------------------------------------
        */

        $contenido = preg_replace(
            '/^\xEF\xBB\xBF/',
            '',
            $contenido
        );

        /*
        |--------------------------------------------------------------------------
        | SEPARAR LÍNEAS
        |--------------------------------------------------------------------------
        */

        $lineas = preg_split(
            '/\r\n|\r|\n/',
            trim($contenido)
        );

        if (count($lineas) < 2) {

            return redirect()
                ->route('aulas.index')
                ->with(
                    'error',
                    'El archivo no contiene aulas para importar.'
                );
        }

        $importados = 0;
        $errores = 0;

        /*
        |--------------------------------------------------------------------------
        | OMITIR ENCABEZADO
        |--------------------------------------------------------------------------
        */

        array_shift($lineas);


        /*
        |--------------------------------------------------------------------------
        | PROCESAR CADA AULA
        |--------------------------------------------------------------------------
        */

        foreach ($lineas as $linea) {

            if (trim($linea) === '') {
                continue;
            }

            $datos = str_getcsv($linea);

            if (count($datos) < 3) {

                $errores++;

                continue;
            }


            /*
            |--------------------------------------------------------------------------
            | OBTENER DATOS
            |--------------------------------------------------------------------------
            */

            $nombre = trim($datos[0]);

            $edificio = trim($datos[1]);

            $capacidad = trim($datos[2]);

            /*
            | La columna activa es opcional.
            | Si no viene, la aula se crea activa.
            */

            $activa = isset($datos[3])
                ? trim($datos[3])
                : '1';


            /*
            |--------------------------------------------------------------------------
            | VALIDAR DATOS
            |--------------------------------------------------------------------------
            */

            if (
                $nombre === '' ||
                $edificio === '' ||
                !is_numeric($capacidad)
            ) {

                $errores++;

                continue;
            }


            $capacidad = (int) $capacidad;


            /*
            |--------------------------------------------------------------------------
            | VALIDAR CAPACIDAD
            |--------------------------------------------------------------------------
            */

            if ($capacidad < 1 || $capacidad > 1000) {

                $errores++;

                continue;
            }


            /*
            |--------------------------------------------------------------------------
            | CONVERTIR ESTADO
            |--------------------------------------------------------------------------
            */

            if (
                $activa === '1' ||
                strtolower($activa) === 'si' ||
                strtolower($activa) === 'sí' ||
                strtolower($activa) === 'activo' ||
                strtolower($activa) === 'activa' ||
                strtolower($activa) === 'true'
            ) {

                $estado = true;

            } else {

                $estado = false;
            }


            /*
            |--------------------------------------------------------------------------
            | CREAR AULA
            |--------------------------------------------------------------------------
            */

            Aula::create([
                'nombre' => $nombre,
                'edificio' => $edificio,
                'capacidad' => $capacidad,
                'activa' => $estado,
            ]);

            $importados++;
        }


        /*
        |--------------------------------------------------------------------------
        | REGRESAR AL INDEX
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('aulas.index')
            ->with(
                'success',
                "Importación terminada. Aulas importadas: {$importados}. Registros con error: {$errores}."
            );
    }
}
