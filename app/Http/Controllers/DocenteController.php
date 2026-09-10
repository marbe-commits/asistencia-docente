<?php

namespace App\Http\Controllers;

use App\Models\Docente;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DocenteController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | LISTADO DE DOCENTES
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $docentes = Docente::orderBy('id', 'desc')->get();

        return view('docentes.index', compact('docentes'));
    }


    /*
    |--------------------------------------------------------------------------
    | FORMULARIO NUEVO DOCENTE
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        return view('docentes.create');
    }


    /*
    |--------------------------------------------------------------------------
    | GUARDAR DOCENTE
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $validated = $request->validate([

            'numero_empleado' => 'nullable|unique:docentes,numero_empleado',

            'nombre' => [
                'required',
                'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ ]+$/'
            ],

            'apellido_paterno' => [
                'required',
                'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ ]+$/'
            ],

            'apellido_materno' => [
                'required',
                'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ ]+$/'
            ],

            'correo' => 'required|email|unique:docentes,correo',

            'telefono' => 'nullable|digits:10'

        ]);


        /*
        |--------------------------------------------------------------------------
        | GENERAR NÚMERO DE EMPLEADO
        |--------------------------------------------------------------------------
        */

        if (empty($validated['numero_empleado'])) {

            $ultimo = Docente::latest('id')->first();

            $numero = $ultimo
                ? $ultimo->id + 1
                : 1;

            $validated['numero_empleado'] =
                'DOC' . str_pad($numero, 3, '0', STR_PAD_LEFT);
        }


        Docente::create($validated);


        return redirect()
            ->route('docentes.index')
            ->with(
                'success',
                'Docente registrado correctamente'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | DESCARGAR PLANTILLA CSV
    |--------------------------------------------------------------------------
    */

    public function descargarPlantilla()
    {
        $nombreArchivo = 'plantilla_docentes.csv';

        $columnas = [
            'numero_empleado',
            'nombre',
            'apellido_paterno',
            'apellido_materno',
            'correo',
            'telefono'
        ];


        $respuesta = new StreamedResponse(function () use ($columnas) {

            $archivo = fopen('php://output', 'w');

            // BOM UTF-8 para Excel
            fprintf(
                $archivo,
                chr(0xEF) . chr(0xBB) . chr(0xBF)
            );

            fputcsv($archivo, $columnas);

            fclose($archivo);
        });


        $respuesta->headers->set(
            'Content-Type',
            'text/csv; charset=UTF-8'
        );

        $respuesta->headers->set(
            'Content-Disposition',
            'attachment; filename="' . $nombreArchivo . '"'
        );


        return $respuesta;
    }


    /*
    |--------------------------------------------------------------------------
    | IMPORTAR DOCENTES DESDE CSV
    |--------------------------------------------------------------------------
    */

    public function importar(Request $request)
    {
        $request->validate([
            'archivo' => 'required|file|mimes:csv,txt|max:2048'
        ]);


        $archivo = $request->file('archivo');

        $ruta = $archivo->getRealPath();

        $handle = fopen($ruta, 'r');


        if (!$handle) {

            return redirect()
                ->route('docentes.index')
                ->with(
                    'error',
                    'No se pudo abrir el archivo CSV.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | ENCABEZADOS
        |--------------------------------------------------------------------------
        */

        $encabezados = fgetcsv($handle);


        if (!$encabezados) {

            fclose($handle);

            return redirect()
                ->route('docentes.index')
                ->with(
                    'error',
                    'El archivo CSV está vacío.'
                );
        }


        // Eliminar BOM
        $encabezados[0] = preg_replace(
            '/^\xEF\xBB\xBF/',
            '',
            $encabezados[0]
        );


        $esperados = [
            'numero_empleado',
            'nombre',
            'apellido_paterno',
            'apellido_materno',
            'correo',
            'telefono'
        ];


        if ($encabezados !== $esperados) {

            fclose($handle);

            return redirect()
                ->route('docentes.index')
                ->with(
                    'error',
                    'El formato del archivo no es correcto. Utiliza la plantilla descargada.'
                );
        }


        $registrados = 0;
        $errores = [];


        /*
        |--------------------------------------------------------------------------
        | LEER FILAS
        |--------------------------------------------------------------------------
        */

        while (($fila = fgetcsv($handle)) !== false) {

            // Ignorar filas vacías

            if (
                count($fila) === 1 &&
                trim($fila[0]) === ''
            ) {
                continue;
            }


            if (count($fila) < 6) {

                $errores[] =
                    'Una fila del archivo no tiene todos los datos necesarios.';

                continue;
            }


            $numeroEmpleado = trim($fila[0]);
            $nombre = trim($fila[1]);
            $apellidoPaterno = trim($fila[2]);
            $apellidoMaterno = trim($fila[3]);
            $correo = trim($fila[4]);
            $telefono = trim($fila[5]);


            /*
            |--------------------------------------------------------------------------
            | NÚMERO DE EMPLEADO
            |--------------------------------------------------------------------------
            */

            if ($numeroEmpleado === '') {

                $ultimo = Docente::latest('id')->first();

                $numero = $ultimo
                    ? $ultimo->id + 1
                    : 1;

                $numeroEmpleado =
                    'DOC' . str_pad(
                        $numero,
                        3,
                        '0',
                        STR_PAD_LEFT
                    );
            }


            /*
            |--------------------------------------------------------------------------
            | VALIDACIONES
            |--------------------------------------------------------------------------
            */

            if ($nombre === '') {

                $errores[] =
                    "El docente con correo {$correo} no tiene nombre.";

                continue;
            }


            if ($apellidoPaterno === '') {

                $errores[] =
                    "El docente {$nombre} no tiene apellido paterno.";

                continue;
            }


            if ($apellidoMaterno === '') {

                $errores[] =
                    "El docente {$nombre} no tiene apellido materno.";

                continue;
            }


            if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {

                $errores[] =
                    "El correo {$correo} no es válido.";

                continue;
            }


            if (
                $telefono !== '' &&
                !preg_match('/^[0-9]{10}$/', $telefono)
            ) {

                $errores[] =
                    "El teléfono del docente {$nombre} debe tener 10 dígitos.";

                continue;
            }


            /*
            |--------------------------------------------------------------------------
            | DUPLICADOS
            |--------------------------------------------------------------------------
            */

            if (
                Docente::where(
                    'numero_empleado',
                    $numeroEmpleado
                )->exists()
            ) {

                $errores[] =
                    "El número de empleado {$numeroEmpleado} ya existe.";

                continue;
            }


            if (
                Docente::where(
                    'correo',
                    $correo
                )->exists()
            ) {

                $errores[] =
                    "El correo {$correo} ya está registrado.";

                continue;
            }


            /*
            |--------------------------------------------------------------------------
            | REGISTRAR
            |--------------------------------------------------------------------------
            */

            Docente::create([

                'numero_empleado' => $numeroEmpleado,

                'nombre' => $nombre,

                'apellido_paterno' => $apellidoPaterno,

                'apellido_materno' => $apellidoMaterno,

                'correo' => $correo,

                'telefono' => $telefono !== ''
                    ? $telefono
                    : null

            ]);


            $registrados++;
        }


        fclose($handle);


        /*
        |--------------------------------------------------------------------------
        | RESULTADO
        |--------------------------------------------------------------------------
        */

        if (count($errores) > 0) {

            return redirect()
                ->route('docentes.index')
                ->with(
                    'error',
                    "Se importaron {$registrados} docentes. " .
                    count($errores) .
                    " registros no fueron importados."
                );
        }


        return redirect()
            ->route('docentes.index')
            ->with(
                'success',
                "Se importaron {$registrados} docentes correctamente."
            );
    }


    /*
    |--------------------------------------------------------------------------
    | MOSTRAR
    |--------------------------------------------------------------------------
    */

    public function show(Docente $docente)
    {
        return view(
            'docentes.show',
            compact('docente')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | EDITAR
    |--------------------------------------------------------------------------
    */

    public function edit(Docente $docente)
    {
        return view(
            'docentes.edit',
            compact('docente')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | ACTUALIZAR
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        Docente $docente
    ) {

        $validated = $request->validate([

            'numero_empleado' =>
                'required|unique:docentes,numero_empleado,' .
                $docente->id,

            'nombre' => [
                'required',
                'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ ]+$/'
            ],

            'apellido_paterno' => [
                'required',
                'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ ]+$/'
            ],

            'apellido_materno' => [
                'required',
                'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ ]+$/'
            ],

            'correo' =>
                'required|email|unique:docentes,correo,' .
                $docente->id,

            'telefono' => 'nullable|digits:10'

        ]);


        $docente->update($validated);


        return redirect()
            ->route('docentes.index')
            ->with(
                'success',
                'Docente actualizado correctamente'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | ELIMINAR
    |--------------------------------------------------------------------------
    */

    public function destroy(Docente $docente)
    {
        $docente->delete();

        return redirect()
            ->route('docentes.index')
            ->with(
                'success',
                'Docente eliminado correctamente'
            );
    }
}