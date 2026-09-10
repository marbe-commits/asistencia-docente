<?php

namespace App\Http\Controllers;

use App\Models\Materia;
use Illuminate\Http\Request;

class MateriaController extends Controller
{
    public function index()
    {
        $materias = Materia::orderBy('id', 'desc')->get();

        return view('materias.index', compact('materias'));
    }

    public function create()
    {
        return view('materias.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'clave' => [
                'required',
                'unique:materias',
                'regex:/^[A-Z]{3,6}[0-9]{3}$/'
            ],

            'nombre' => [
                'required',
                'string',
                'max:100',
                'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ ]+$/'
            ],

            'cuatrimestre' => 'required|integer|between:1,12',

            'descripcion' => 'nullable|string|max:500'

        ], [

            'clave.regex' =>
                'La clave debe llevar formato tipo MAT101 o PROG205.',

            'nombre.regex' =>
                'El nombre solo acepta letras y espacios.',

            'cuatrimestre.between' =>
                'Solo se permiten cuatrimestres del 1 al 12.'

        ]);

        Materia::create($validated);

        return redirect()
            ->route('materias.index')
            ->with('success', 'Materia registrada correctamente');
    }

    public function show(Materia $materia)
    {
        //
    }

    public function edit(Materia $materia)
    {
        return view('materias.edit', compact('materia'));
    }

    public function update(Request $request, Materia $materia)
    {
        $validated = $request->validate([

            'clave' => [
                'required',
                'unique:materias,clave,' . $materia->id,
                'regex:/^[A-Z]{3,6}[0-9]{3}$/'
            ],

            'nombre' => [
                'required',
                'string',
                'max:100',
                'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ ]+$/'
            ],

            'cuatrimestre' =>
                'required|integer|between:1,12',

            'descripcion' =>
                'nullable|string|max:500'

        ], [

            'clave.regex' =>
                'La clave debe llevar formato tipo MAT101 o PROG205.',

            'nombre.regex' =>
                'El nombre solo acepta letras y espacios.',

            'cuatrimestre.between' =>
                'Solo se permiten cuatrimestres del 1 al 12.'

        ]);

        $materia->update($validated);

        return redirect()
            ->route('materias.index')
            ->with('success', 'Materia actualizada correctamente');
    }

    public function destroy(Materia $materia)
    {
        $materia->delete();

        return redirect()
            ->route('materias.index')
            ->with('success', 'Materia eliminada correctamente');
    }


    /*
    |--------------------------------------------------------------------------
    | DESCARGAR PLANTILLA
    |--------------------------------------------------------------------------
    */

    public function descargarPlantilla()
    {
        $nombreArchivo = 'plantilla_materias.csv';

        $contenido = "\xEF\xBB\xBF";

        $contenido .= "clave,nombre,cuatrimestre,descripcion\n";

        $contenido .= "MAT101,Matematicas,1,Introduccion a las matematicas\n";

        $contenido .= "PROG205,Programacion,2,Fundamentos de programacion\n";


        return response($contenido)
            ->header('Content-Type', 'text/csv; charset=UTF-8')
            ->header(
                'Content-Disposition',
                'attachment; filename="' . $nombreArchivo . '"'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | IMPORTAR MATERIAS
    |--------------------------------------------------------------------------
    */

    public function importar(Request $request)
    {
        $request->validate([
            'archivo' => 'required|file|mimes:csv,txt|max:2048'
        ], [

            'archivo.required' =>
                'Selecciona un archivo para importar.',

            'archivo.mimes' =>
                'El archivo debe estar en formato CSV.',

            'archivo.max' =>
                'El archivo no debe superar los 2 MB.'

        ]);


        $archivo = $request->file('archivo');

        $ruta = $archivo->getRealPath();

        $handle = fopen($ruta, 'r');


        if (!$handle) {

            return redirect()
                ->route('materias.index')
                ->with('error', 'No fue posible abrir el archivo.');

        }


        /*
        |--------------------------------------------------------------------------
        | LEER ENCABEZADO
        |--------------------------------------------------------------------------
        */

        $encabezado = fgetcsv($handle);


        if (!$encabezado) {

            fclose($handle);

            return redirect()
                ->route('materias.index')
                ->with('error', 'El archivo está vacío.');

        }


        /*
        |--------------------------------------------------------------------------
        | LIMPIAR BOM Y ENCABEZADOS
        |--------------------------------------------------------------------------
        */

        $encabezado[0] = preg_replace(
            '/^\xEF\xBB\xBF/',
            '',
            $encabezado[0]
        );


        $encabezado = array_map(
            function ($valor) {
                return strtolower(trim($valor));
            },
            $encabezado
        );


        /*
        |--------------------------------------------------------------------------
        | VERIFICAR COLUMNAS
        |--------------------------------------------------------------------------
        */

        $columnasEsperadas = [
            'clave',
            'nombre',
            'cuatrimestre',
            'descripcion'
        ];


        foreach ($columnasEsperadas as $columna) {

            if (!in_array($columna, $encabezado)) {

                fclose($handle);

                return redirect()
                    ->route('materias.index')
                    ->with(
                        'error',
                        'El archivo no tiene el formato correcto. Descarga primero la plantilla.'
                    );

            }

        }


        /*
        |--------------------------------------------------------------------------
        | POSICIONES DE LAS COLUMNAS
        |--------------------------------------------------------------------------
        */

        $posClave =
            array_search('clave', $encabezado);

        $posNombre =
            array_search('nombre', $encabezado);

        $posCuatrimestre =
            array_search('cuatrimestre', $encabezado);

        $posDescripcion =
            array_search('descripcion', $encabezado);


        $importadas = 0;

        $omitidas = 0;


        /*
        |--------------------------------------------------------------------------
        | PROCESAR FILAS
        |--------------------------------------------------------------------------
        */

        while (($fila = fgetcsv($handle)) !== false) {

            if (count($fila) < 4) {

                $omitidas++;

                continue;

            }


            $clave =
                strtoupper(trim($fila[$posClave]));

            $nombre =
                trim($fila[$posNombre]);

            $cuatrimestre =
                trim($fila[$posCuatrimestre]);

            $descripcion =
                trim($fila[$posDescripcion]);


            /*
            |--------------------------------------------------------------------------
            | IGNORAR FILAS VACÍAS
            |--------------------------------------------------------------------------
            */

            if (
                empty($clave) &&
                empty($nombre) &&
                empty($cuatrimestre)
            ) {

                continue;

            }


            /*
            |--------------------------------------------------------------------------
            | VALIDAR DATOS
            |--------------------------------------------------------------------------
            */

            if (
                !preg_match(
                    '/^[A-Z]{3,6}[0-9]{3}$/',
                    $clave
                )
            ) {

                $omitidas++;

                continue;

            }


            if (
                !preg_match(
                    '/^[A-Za-zÁÉÍÓÚáéíóúÑñ ]+$/u',
                    $nombre
                )
            ) {

                $omitidas++;

                continue;

            }


            if (
                !is_numeric($cuatrimestre) ||
                $cuatrimestre < 1 ||
                $cuatrimestre > 12
            ) {

                $omitidas++;

                continue;

            }


            /*
            |--------------------------------------------------------------------------
            | EVITAR MATERIAS DUPLICADAS
            |--------------------------------------------------------------------------
            */

            if (
                Materia::where(
                    'clave',
                    $clave
                )->exists()
            ) {

                $omitidas++;

                continue;

            }


            /*
            |--------------------------------------------------------------------------
            | CREAR MATERIA
            |--------------------------------------------------------------------------
            */

            Materia::create([

                'clave' =>
                    $clave,

                'nombre' =>
                    $nombre,

                'cuatrimestre' =>
                    (int) $cuatrimestre,

                'descripcion' =>
                    $descripcion ?: null

            ]);


            $importadas++;

        }


        fclose($handle);


        /*
        |--------------------------------------------------------------------------
        | MENSAJE FINAL
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('materias.index')
            ->with(
                'success',
                "Importación terminada. Materias importadas: {$importadas}. Filas omitidas: {$omitidas}."
            );
    }
}