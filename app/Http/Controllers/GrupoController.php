<?php

namespace App\Http\Controllers;

use App\Models\Grupo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class GrupoController extends Controller
{
    public function index()
    {
        $grupos = Grupo::all();

        return view('grupos.index', compact('grupos'));
    }

    public function create()
    {
        return view('grupos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre'         => 'required|string|max:100',
            'carrera'        => 'required|string|max:100',
            'cuatrimestre'   => 'required|integer|between:1,12',
            'numero_alumnos' => 'required|integer|between:1,100',
        ]);

        Grupo::create($request->all());

        return redirect()
            ->route('grupos.index')
            ->with('success', 'Grupo creado correctamente.');
    }

    public function edit(Grupo $grupo)
    {
        return view('grupos.edit', compact('grupo'));
    }

    public function update(Request $request, Grupo $grupo)
    {
        $request->validate([
            'nombre'         => 'required|string|max:100',
            'carrera'        => 'required|string|max:100',
            'cuatrimestre'   => 'required|integer|between:1,12',
            'numero_alumnos' => 'required|integer|between:1,100',
        ]);

        $grupo->update($request->all());

        return redirect()
            ->route('grupos.index')
            ->with('success', 'Grupo actualizado correctamente.');
    }

    public function destroy(Grupo $grupo)
    {
        $grupo->delete();

        return redirect()
            ->route('grupos.index')
            ->with('success', 'Grupo eliminado correctamente.');
    }


    /*
    |--------------------------------------------------------------------------
    | DESCARGAR PLANTILLA
    |--------------------------------------------------------------------------
    */

    public function descargarPlantilla()
    {
        $contenido = "\xEF\xBB\xBF";

        $contenido .= "nombre,carrera,cuatrimestre,numero_alumnos\n";

        $contenido .= "8MSC3,Ingeniería en Sistemas Computacionales,8,25\n";

        $contenido .= "TI-041,Ingeniería en Sistemas,2,23\n";

        return Response::make(
            $contenido,
            200,
            [
                'Content-Type' => 'text/csv; charset=UTF-8',
                'Content-Disposition' => 'attachment; filename="plantilla_grupos.csv"',
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | IMPORTAR GRUPOS
    |--------------------------------------------------------------------------
    */

    public function importar(Request $request)
    {
        $request->validate([
            'archivo' => 'required|file|mimes:csv,txt|max:2048',
        ], [
            'archivo.required' => 'Selecciona un archivo.',
            'archivo.file'     => 'El archivo no es válido.',
            'archivo.mimes'    => 'El archivo debe ser CSV.',
            'archivo.max'      => 'El archivo no puede superar los 2 MB.',
        ]);

        $archivo = $request->file('archivo');

        $contenido = file_get_contents($archivo->getRealPath());

        $contenido = preg_replace('/^\xEF\xBB\xBF/', '', $contenido);

        $lineas = preg_split('/\r\n|\r|\n/', trim($contenido));

        if (count($lineas) < 2) {
            return redirect()
                ->route('grupos.index')
                ->with('error', 'El archivo no contiene grupos para importar.');
        }

        $importados = 0;
        $errores = 0;

        /*
        |--------------------------------------------------------------------------
        | OMITIR ENCABEZADO
        |--------------------------------------------------------------------------
        */

        array_shift($lineas);

        foreach ($lineas as $linea) {

            if (trim($linea) === '') {
                continue;
            }

            $datos = str_getcsv($linea);

            if (count($datos) < 4) {
                $errores++;
                continue;
            }

            $nombre = trim($datos[0]);
            $carrera = trim($datos[1]);
            $cuatrimestre = trim($datos[2]);
            $numero_alumnos = trim($datos[3]);

            /*
            |--------------------------------------------------------------------------
            | VALIDACIONES
            |--------------------------------------------------------------------------
            */

            if (
                $nombre === '' ||
                $carrera === '' ||
                !is_numeric($cuatrimestre) ||
                !is_numeric($numero_alumnos)
            ) {
                $errores++;
                continue;
            }

            $cuatrimestre = (int) $cuatrimestre;
            $numero_alumnos = (int) $numero_alumnos;

            if ($cuatrimestre < 1 || $cuatrimestre > 12) {
                $errores++;
                continue;
            }

            if ($numero_alumnos < 1 || $numero_alumnos > 100) {
                $errores++;
                continue;
            }

            /*
            |--------------------------------------------------------------------------
            | CREAR GRUPO
            |--------------------------------------------------------------------------
            */

            Grupo::create([
                'nombre' => $nombre,
                'carrera' => $carrera,
                'cuatrimestre' => $cuatrimestre,
                'numero_alumnos' => $numero_alumnos,
            ]);

            $importados++;
        }

        return redirect()
            ->route('grupos.index')
            ->with(
                'success',
                "Importación terminada. Grupos importados: {$importados}. Registros con error: {$errores}."
            );
    }
}