<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Grupo;
use App\Models\CodigoQR;
use App\Models\Asistencia;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AlumnoController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | LISTADO DE ALUMNOS
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $alumnos = Alumno::with('grupo')
            ->orderBy('id', 'desc')
            ->get();

        return view('alumnos.index', compact('alumnos'));
    }


    /*
    |--------------------------------------------------------------------------
    | FORMULARIO CREAR
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        $grupos = Grupo::orderBy('nombre')->get();

        return view('alumnos.create', compact('grupos'));
    }


    /*
    |--------------------------------------------------------------------------
    | GUARDAR ALUMNO
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $validated = $request->validate([
            'matricula' => [
                'required',
                'unique:alumnos,matricula',
                'regex:/^[0-9]{8,9}$/'
            ],

            'nombre' => [
                'required',
                'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ ]+$/u'
            ],

            'apellido_paterno' => [
                'required',
                'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ ]+$/u'
            ],

            'apellido_materno' => [
                'required',
                'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ ]+$/u'
            ],

            'correo' => [
                'required',
                'email',
                'unique:alumnos,correo'
            ],

            'grupo_id' => [
                'required',
                'exists:grupos,id'
            ]
        ], [
            'matricula.required' => 'La matrícula es obligatoria.',
            'matricula.unique' => 'La matrícula ya está registrada.',
            'matricula.regex' => 'La matrícula debe tener 8 o 9 números.',

            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.regex' => 'El nombre solo puede contener letras.',

            'apellido_paterno.required' => 'El apellido paterno es obligatorio.',
            'apellido_paterno.regex' => 'El apellido paterno solo puede contener letras.',

            'apellido_materno.required' => 'El apellido materno es obligatorio.',
            'apellido_materno.regex' => 'El apellido materno solo puede contener letras.',

            'correo.required' => 'El correo es obligatorio.',
            'correo.email' => 'El correo no tiene un formato válido.',
            'correo.unique' => 'El correo ya está registrado.',

            'grupo_id.required' => 'Debes seleccionar un grupo.',
            'grupo_id.exists' => 'El grupo seleccionado no existe.'
        ]);

        $validated['user_id'] = auth()->id();

        Alumno::create($validated);

        return redirect()
            ->route('alumnos.index')
            ->with('success', 'Alumno registrado correctamente.');
    }


    /*
    |--------------------------------------------------------------------------
    | FORMULARIO EDITAR
    |--------------------------------------------------------------------------
    */

    public function edit(Alumno $alumno)
    {
        $grupos = Grupo::orderBy('nombre')->get();

        return view(
            'alumnos.edit',
            compact('alumno', 'grupos')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | ACTUALIZAR ALUMNO
    |--------------------------------------------------------------------------
    */

    public function update(Request $request, Alumno $alumno)
    {
        $validated = $request->validate([
            'matricula' => [
                'required',
                'unique:alumnos,matricula,' . $alumno->id,
                'regex:/^[0-9]{8,9}$/'
            ],

            'nombre' => [
                'required',
                'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ ]+$/u'
            ],

            'apellido_paterno' => [
                'required',
                'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ ]+$/u'
            ],

            'apellido_materno' => [
                'required',
                'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ ]+$/u'
            ],

            'correo' => [
                'required',
                'email',
                'unique:alumnos,correo,' . $alumno->id
            ],

            'grupo_id' => [
                'required',
                'exists:grupos,id'
            ]
        ], [
            'matricula.regex' => 'La matrícula debe tener 8 o 9 números.',
            'nombre.regex' => 'Solo letras permitidas.',
            'apellido_paterno.regex' => 'Solo letras permitidas.',
            'apellido_materno.regex' => 'Solo letras permitidas.'
        ]);

        $grupoAnterior = $alumno->grupo_id;

        $validated['user_id'] = auth()->id();

        $alumno->update($validated);

        /*
        |--------------------------------------------------------------------------
        | ACTUALIZAR CANTIDAD DE ALUMNOS DE LOS GRUPOS
        |--------------------------------------------------------------------------
        */

        if ($grupoAnterior != $validated['grupo_id']) {

            if ($grupoAnterior) {
                Grupo::where('id', $grupoAnterior)
                    ->update([
                        'numero_alumnos' => Alumno::where(
                            'grupo_id',
                            $grupoAnterior
                        )->count()
                    ]);
            }

            Grupo::where('id', $validated['grupo_id'])
                ->update([
                    'numero_alumnos' => Alumno::where(
                        'grupo_id',
                        $validated['grupo_id']
                    )->count()
                ]);
        }

        return redirect()
            ->route('alumnos.index')
            ->with(
                'success',
                'Alumno actualizado correctamente.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | ELIMINAR ALUMNO
    |--------------------------------------------------------------------------
    */

    public function destroy(Alumno $alumno)
    {
        $grupoId = $alumno->grupo_id;

        $alumno->delete();

        /*
        |--------------------------------------------------------------------------
        | ACTUALIZAR TOTAL DEL GRUPO
        |--------------------------------------------------------------------------
        */

        if ($grupoId) {

            Grupo::where('id', $grupoId)
                ->update([
                    'numero_alumnos' => Alumno::where(
                        'grupo_id',
                        $grupoId
                    )->count()
                ]);
        }

        return redirect()
            ->route('alumnos.index')
            ->with(
                'success',
                'Alumno eliminado correctamente.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | DESCARGAR PLANTILLA CSV
    |--------------------------------------------------------------------------
    */

    public function descargarPlantilla()
    {
        $nombreArchivo = 'plantilla_alumnos.csv';

        return response()->streamDownload(function () {

            $archivo = fopen('php://output', 'w');

            /*
            |--------------------------------------------------------------------------
            | BOM UTF-8
            |--------------------------------------------------------------------------
            */

            fwrite(
                $archivo,
                "\xEF\xBB\xBF"
            );

            /*
            |--------------------------------------------------------------------------
            | ENCABEZADOS
            |--------------------------------------------------------------------------
            */

            fputcsv($archivo, [
                'matricula',
                'nombre',
                'apellido_paterno',
                'apellido_materno',
                'correo',
                'grupo'
            ]);

            /*
            |--------------------------------------------------------------------------
            | EJEMPLO
            |--------------------------------------------------------------------------
            |
            | Puedes borrar esta fila antes de importar.
            |
            */

            fputcsv($archivo, [
                '221550235',
                'José Isaac',
                'Sánchez',
                'Sánchez',
                'ejemplo@gmail.com',
                '8VSC3'
            ]);

            fclose($archivo);

        }, $nombreArchivo, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' =>
                'attachment; filename="' . $nombreArchivo . '"'
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | IMPORTAR ALUMNOS DESDE CSV
    |--------------------------------------------------------------------------
    */

    public function importar(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | VALIDAR ARCHIVO
        |--------------------------------------------------------------------------
        */

        $request->validate([
            'archivo' => [
                'required',
                'file',
                'mimes:csv,txt',
                'max:5120'
            ]
        ], [
            'archivo.required' =>
                'Debes seleccionar un archivo CSV.',

            'archivo.file' =>
                'El archivo seleccionado no es válido.',

            'archivo.mimes' =>
                'El archivo debe ser CSV.',

            'archivo.max' =>
                'El archivo no puede superar los 5 MB.'
        ]);


        $archivo = $request->file('archivo');

        $handle = fopen(
            $archivo->getRealPath(),
            'r'
        );


        if (!$handle) {

            return back()->with(
                'error',
                'No se pudo abrir el archivo CSV.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | DETECTAR SEPARADOR
        |--------------------------------------------------------------------------
        */

        $primeraLinea = fgets($handle);

        if ($primeraLinea === false) {

            fclose($handle);

            return back()->with(
                'error',
                'El archivo CSV está vacío.'
            );
        }


        /*
        | Puede venir de Excel con ; o con ,
        */

        $separador = ',';

        if (
            substr_count($primeraLinea, ';') >
            substr_count($primeraLinea, ',')
        ) {
            $separador = ';';
        }


        /*
        |--------------------------------------------------------------------------
        | REGRESAR AL INICIO
        |--------------------------------------------------------------------------
        */

        rewind($handle);


        /*
        |--------------------------------------------------------------------------
        | ENCABEZADOS
        |--------------------------------------------------------------------------
        */

        $encabezados = fgetcsv(
            $handle,
            0,
            $separador
        );


        if (!$encabezados) {

            fclose($handle);

            return back()->with(
                'error',
                'El archivo CSV no contiene encabezados.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | LIMPIAR ENCABEZADOS
        |--------------------------------------------------------------------------
        */

        $encabezados = array_map(
            function ($encabezado) {

                $encabezado = preg_replace(
                    '/^\xEF\xBB\xBF/',
                    '',
                    $encabezado
                );

                return strtolower(
                    trim($encabezado)
                );
            },
            $encabezados
        );


        /*
        |--------------------------------------------------------------------------
        | COLUMNAS ESPERADAS
        |--------------------------------------------------------------------------
        */

        $esperados = [
            'matricula',
            'nombre',
            'apellido_paterno',
            'apellido_materno',
            'correo',
            'grupo'
        ];


        if ($encabezados !== $esperados) {

            fclose($handle);

            return back()
                ->with(
                    'error',
                    'Las columnas de la plantilla no son correctas.'
                )
                ->with(
                    'detalle_columnas',
                    'Debe contener exactamente: matricula, nombre, apellido_paterno, apellido_materno, correo, grupo.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | CONTADORES
        |--------------------------------------------------------------------------
        */

        $importados = 0;

        $errores = [];

        $fila = 1;


        /*
        |--------------------------------------------------------------------------
        | LEER FILAS
        |--------------------------------------------------------------------------
        */

        while (($datos = fgetcsv(
            $handle,
            0,
            $separador
        )) !== false) {

            $fila++;


            /*
            |--------------------------------------------------------------------------
            | IGNORAR FILAS VACÍAS
            |--------------------------------------------------------------------------
            */

            $datosLimpios = array_map(
                function ($dato) {
                    return trim($dato ?? '');
                },
                $datos
            );


            if (
                count(
                    array_filter(
                        $datosLimpios,
                        function ($valor) {
                            return $valor !== '';
                        }
                    )
                ) === 0
            ) {
                continue;
            }


            /*
            |--------------------------------------------------------------------------
            | VALIDAR COLUMNAS
            |--------------------------------------------------------------------------
            */

            if (count($datosLimpios) < 6) {

                $errores[] =
                    "Fila {$fila}: faltan columnas.";

                continue;
            }


            /*
            |--------------------------------------------------------------------------
            | OBTENER DATOS
            |--------------------------------------------------------------------------
            */

            $matricula =
                trim($datosLimpios[0]);

            $nombre =
                trim($datosLimpios[1]);

            $apellidoPaterno =
                trim($datosLimpios[2]);

            $apellidoMaterno =
                trim($datosLimpios[3]);

            $correo =
                trim($datosLimpios[4]);

            $nombreGrupo =
                trim($datosLimpios[5]);


            /*
            |--------------------------------------------------------------------------
            | LIMPIAR MATRÍCULA
            |--------------------------------------------------------------------------
            */

            $matricula =
                preg_replace(
                    '/\s+/',
                    '',
                    $matricula
                );


            /*
            |--------------------------------------------------------------------------
            | VALIDAR MATRÍCULA
            |--------------------------------------------------------------------------
            */

            if (
                !preg_match(
                    '/^[0-9]{8,9}$/',
                    $matricula
                )
            ) {

                $errores[] =
                    "Fila {$fila}: la matrícula '{$matricula}' debe tener 8 o 9 números.";

                continue;
            }


            /*
            |--------------------------------------------------------------------------
            | VALIDAR NOMBRE
            |--------------------------------------------------------------------------
            */

            if (
                !preg_match(
                    '/^[A-Za-zÁÉÍÓÚáéíóúÑñ ]+$/u',
                    $nombre
                )
            ) {

                $errores[] =
                    "Fila {$fila}: el nombre '{$nombre}' no es válido.";

                continue;
            }


            /*
            |--------------------------------------------------------------------------
            | VALIDAR APELLIDO PATERNO
            |--------------------------------------------------------------------------
            */

            if (
                !preg_match(
                    '/^[A-Za-zÁÉÍÓÚáéíóúÑñ ]+$/u',
                    $apellidoPaterno
                )
            ) {

                $errores[] =
                    "Fila {$fila}: el apellido paterno no es válido.";

                continue;
            }


            /*
            |--------------------------------------------------------------------------
            | VALIDAR APELLIDO MATERNO
            |--------------------------------------------------------------------------
            */

            if (
                !preg_match(
                    '/^[A-Za-zÁÉÍÓÚáéíóúÑñ ]+$/u',
                    $apellidoMaterno
                )
            ) {

                $errores[] =
                    "Fila {$fila}: el apellido materno no es válido.";

                continue;
            }


            /*
            |--------------------------------------------------------------------------
            | VALIDAR CORREO
            |--------------------------------------------------------------------------
            */

            if (
                !filter_var(
                    $correo,
                    FILTER_VALIDATE_EMAIL
                )
            ) {

                $errores[] =
                    "Fila {$fila}: el correo '{$correo}' no es válido.";

                continue;
            }


            /*
            |--------------------------------------------------------------------------
            | LIMPIAR NOMBRE DEL GRUPO
            |--------------------------------------------------------------------------
            */

            $nombreGrupo = trim(
                preg_replace(
                    '/\s+/',
                    ' ',
                    $nombreGrupo
                )
            );


            /*
            |--------------------------------------------------------------------------
            | BUSCAR GRUPO
            |--------------------------------------------------------------------------
            |
            | IMPORTANTE:
            |
            | La búsqueda se hace ignorando mayúsculas/minúsculas.
            |
            | 8VSC3
            | 8vsc3
            | 8Vsc3
            |
            | serán considerados el mismo grupo.
            |
            */

            $grupo = Grupo::whereRaw(
                'LOWER(TRIM(nombre)) = ?',
                [
                    strtolower($nombreGrupo)
                ]
            )->first();


            /*
            |--------------------------------------------------------------------------
            | GRUPO NO EXISTE
            |--------------------------------------------------------------------------
            */

            if (!$grupo) {

                $errores[] =
                    "Fila {$fila}: el grupo '{$nombreGrupo}' no existe en la base de datos.";

                continue;
            }


            /*
            |--------------------------------------------------------------------------
            | MATRÍCULA DUPLICADA
            |--------------------------------------------------------------------------
            */

            if (
                Alumno::where(
                    'matricula',
                    $matricula
                )->exists()
            ) {

                $errores[] =
                    "Fila {$fila}: la matrícula '{$matricula}' ya existe.";

                continue;
            }


            /*
            |--------------------------------------------------------------------------
            | CORREO DUPLICADO
            |--------------------------------------------------------------------------
            */

            if (
                Alumno::where(
                    'correo',
                    $correo
                )->exists()
            ) {

                $errores[] =
                    "Fila {$fila}: el correo '{$correo}' ya existe.";

                continue;
            }


            /*
            |--------------------------------------------------------------------------
            | CREAR ALUMNO
            |--------------------------------------------------------------------------
            */

            try {

                Alumno::create([

                    'matricula' =>
                        $matricula,

                    'nombre' =>
                        $nombre,

                    'apellido_paterno' =>
                        $apellidoPaterno,

                    'apellido_materno' =>
                        $apellidoMaterno,

                    'correo' =>
                        $correo,

                    'grupo_id' =>
                        $grupo->id,

                    'user_id' =>
                        auth()->id()

                ]);


                /*
                |--------------------------------------------------------------------------
                | ACTUALIZAR CANTIDAD DEL GRUPO
                |--------------------------------------------------------------------------
                */

                $grupo->update([
                    'numero_alumnos' =>
                        Alumno::where(
                            'grupo_id',
                            $grupo->id
                        )->count()
                ]);


                $importados++;

            } catch (\Exception $e) {

                $errores[] =
                    "Fila {$fila}: no se pudo registrar al alumno. " .
                    $e->getMessage();

                continue;
            }
        }


        fclose($handle);


        /*
        |--------------------------------------------------------------------------
        | RESULTADO
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('alumnos.index')
            ->with(
                'success',
                "{$importados} alumnos importados correctamente."
            )
            ->with(
                'errores_importacion',
                $errores
            );
    }


    /*
    |--------------------------------------------------------------------------
    | EXPORTAR ALUMNOS
    |--------------------------------------------------------------------------
    */

    public function exportar()
    {
        $alumnos = Alumno::with('grupo')
            ->orderBy('grupo_id')
            ->orderBy('apellido_paterno')
            ->get();


        return response()->streamDownload(
            function () use ($alumnos) {

                $archivo = fopen(
                    'php://output',
                    'w'
                );


                /*
                |--------------------------------------------------------------------------
                | BOM UTF-8
                |--------------------------------------------------------------------------
                */

                fwrite(
                    $archivo,
                    "\xEF\xBB\xBF"
                );


                /*
                |--------------------------------------------------------------------------
                | ENCABEZADOS
                |--------------------------------------------------------------------------
                */

                fputcsv($archivo, [
                    'matricula',
                    'nombre',
                    'apellido_paterno',
                    'apellido_materno',
                    'correo',
                    'grupo'
                ]);


                /*
                |--------------------------------------------------------------------------
                | DATOS
                |--------------------------------------------------------------------------
                */

                foreach ($alumnos as $alumno) {

                    fputcsv($archivo, [

                        $alumno->matricula,

                        $alumno->nombre,

                        $alumno->apellido_paterno,

                        $alumno->apellido_materno,

                        $alumno->correo,

                        optional($alumno->grupo)->nombre

                    ]);
                }


                fclose($archivo);

            },
            'alumnos_exportados.csv',
            [
                'Content-Type' =>
                    'text/csv; charset=UTF-8',

                'Content-Disposition' =>
                    'attachment; filename="alumnos_exportados.csv"'
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | ESCANEAR QR
    |--------------------------------------------------------------------------
    */

    public function escanear()
    {
        return view('alumnos.escanear');
    }


    /*
|--------------------------------------------------------------------------
| REGISTRAR ASISTENCIA
|--------------------------------------------------------------------------
*/

public function registrarAsistencia(Request $request)
{
    /*
    |--------------------------------------------------------------------------
    | VALIDAR DATOS
    |--------------------------------------------------------------------------
    */

    $validated = $request->validate([
        'codigo' => [
            'required',
            'string'
        ],

        'matricula' => [
            'required',
            'string'
        ],

        'latitud' => [
            'required',
            'numeric'
        ],

        'longitud' => [
            'required',
            'numeric'
        ]
    ]);


    /*
    |--------------------------------------------------------------------------
    | BUSCAR CÓDIGO QR
    |--------------------------------------------------------------------------
    */

    $qr = CodigoQR::with('clase')
        ->where('codigo', $validated['codigo'])
        ->where('activo', 1)
        ->first();


    if (!$qr) {

        return response()->make('
            <!DOCTYPE html>

            <html lang="es">

            <head>

                <meta charset="UTF-8">

                <meta
                    name="viewport"
                    content="width=device-width, initial-scale=1.0"
                >

                <title>QR inválido</title>

                <style>

                    body {
                        font-family: Arial, sans-serif;
                        background: #f3f4f6;
                        display: flex;
                        justify-content: center;
                        align-items: center;
                        min-height: 100vh;
                        margin: 0;
                    }

                    .card {
                        background: white;
                        padding: 40px;
                        border-radius: 20px;
                        box-shadow: 0 10px 30px rgba(0,0,0,.15);
                        text-align: center;
                        max-width: 420px;
                        margin: 20px;
                    }

                    h2 {
                        color: #dc2626;
                    }

                    p {
                        color: #555;
                    }

                </style>

            </head>

            <body>

                <div class="card">

                    <h2>❌ QR inválido o expirado</h2>

                    <p>
                        El código QR ya no está disponible.
                    </p>

                </div>

            </body>

            </html>
        ', 404);
    }


    /*
    |--------------------------------------------------------------------------
    | BUSCAR ALUMNO
    |--------------------------------------------------------------------------
    */

    $alumno = Alumno::where(
        'matricula',
        trim($validated['matricula'])
    )->first();


    if (!$alumno) {

        return response()->make('
            <!DOCTYPE html>

            <html lang="es">

            <head>

                <meta charset="UTF-8">

                <meta
                    name="viewport"
                    content="width=device-width, initial-scale=1.0"
                >

                <title>Alumno no encontrado</title>

                <style>

                    body {
                        font-family: Arial, sans-serif;
                        background: #f3f4f6;
                        display: flex;
                        justify-content: center;
                        align-items: center;
                        min-height: 100vh;
                        margin: 0;
                    }

                    .card {
                        background: white;
                        padding: 40px;
                        border-radius: 20px;
                        box-shadow: 0 10px 30px rgba(0,0,0,.15);
                        text-align: center;
                        max-width: 420px;
                        margin: 20px;
                    }

                    h2 {
                        color: #dc2626;
                    }

                    p {
                        color: #555;
                    }

                </style>

            </head>

            <body>

                <div class="card">

                    <h2>❌ Alumno no encontrado</h2>

                    <p>
                        La matrícula ingresada no existe.
                    </p>

                    <p>
                        Matrícula:
                        <strong>
                            ' . htmlspecialchars($validated['matricula']) . '
                        </strong>
                    </p>

                </div>

            </body>

            </html>
        ', 404);
    }


    /*
    |--------------------------------------------------------------------------
    | COORDENADAS DE LA UNIVERSIDAD
    |--------------------------------------------------------------------------
    */

    $latitudUPT = 19.450751;

    $longitudUPT = -98.899167;

    $radioPermitido = 200;


    /*
    |--------------------------------------------------------------------------
    | CALCULAR DISTANCIA
    |--------------------------------------------------------------------------
    */

    $distancia = $this->calcularDistancia(

        $validated['latitud'],

        $validated['longitud'],

        $latitudUPT,

        $longitudUPT

    );


    /*
    |--------------------------------------------------------------------------
    | VALIDAR UBICACIÓN
    |--------------------------------------------------------------------------
    */

    if ($distancia > $radioPermitido) {

        return response()->make('
            <!DOCTYPE html>

            <html lang="es">

            <head>

                <meta charset="UTF-8">

                <meta
                    name="viewport"
                    content="width=device-width, initial-scale=1.0"
                >

                <title>Ubicación no válida</title>

                <style>

                    body {
                        font-family: Arial, sans-serif;
                        background: #f3f4f6;
                        display: flex;
                        justify-content: center;
                        align-items: center;
                        min-height: 100vh;
                        margin: 0;
                    }

                    .card {
                        background: white;
                        padding: 40px;
                        border-radius: 20px;
                        box-shadow: 0 10px 30px rgba(0,0,0,.15);
                        text-align: center;
                        max-width: 420px;
                        margin: 20px;
                    }

                    h2 {
                        color: #dc2626;
                    }

                    p {
                        color: #555;
                    }

                </style>

            </head>

            <body>

                <div class="card">

                    <h2>❌ Asistencia rechazada</h2>

                    <p>
                        No te encuentras dentro de la zona permitida.
                    </p>

                    <p>
                        Distancia detectada:
                        <strong>
                            ' . round($distancia) . ' metros
                        </strong>
                    </p>

                    <p>
                        Distancia máxima permitida:
                        <strong>
                            ' . $radioPermitido . ' metros
                        </strong>
                    </p>

                </div>

            </body>

            </html>
        ', 403);
    }


    /*
    |--------------------------------------------------------------------------
    | VERIFICAR QUE LA CLASE EXISTA
    |--------------------------------------------------------------------------
    */

    if (!$qr->clase) {

        return response()->make('
            <!DOCTYPE html>

            <html lang="es">

            <head>

                <meta charset="UTF-8">

                <meta
                    name="viewport"
                    content="width=device-width, initial-scale=1.0"
                >

                <title>Error</title>

            </head>

            <body>

                <h2>❌ Error</h2>

                <p>
                    El código QR no está asociado a una clase.
                </p>

            </body>

            </html>
        ', 500);
    }


    /*
    |--------------------------------------------------------------------------
    | EVITAR ASISTENCIA DUPLICADA
    |--------------------------------------------------------------------------
    */

    $asistenciaExiste = Asistencia::where(
        'alumno_id',
        $alumno->id
    )
    ->where(
        'clase_id',
        $qr->clase_id
    )
    ->exists();


    if ($asistenciaExiste) {

        return response()->make('
            <!DOCTYPE html>

            <html lang="es">

            <head>

                <meta charset="UTF-8">

                <meta
                    name="viewport"
                    content="width=device-width, initial-scale=1.0"
                >

                <title>Asistencia ya registrada</title>

                <style>

                    body {
                        font-family: Arial, sans-serif;
                        background: #f3f4f6;
                        display: flex;
                        justify-content: center;
                        align-items: center;
                        min-height: 100vh;
                        margin: 0;
                    }

                    .card {
                        background: white;
                        padding: 40px;
                        border-radius: 20px;
                        box-shadow: 0 10px 30px rgba(0,0,0,.15);
                        text-align: center;
                        max-width: 420px;
                        margin: 20px;
                    }

                    h2 {
                        color: #ca8a04;
                    }

                    p {
                        color: #555;
                    }

                </style>

            </head>

            <body>

                <div class="card">

                    <h2>⚠️ Asistencia ya registrada</h2>

                    <p>
                        Este alumno ya registró su asistencia
                        para esta clase.
                    </p>

                </div>

            </body>

            </html>
        ', 409);
    }


    /*
    |--------------------------------------------------------------------------
    | OBTENER DOCENTE
    |--------------------------------------------------------------------------
    |
    | La clase tiene directamente al profesor.
    |
    */

    $docenteId = $qr->clase->horario->docente_id;


    /*
    |--------------------------------------------------------------------------
    | GUARDAR ASISTENCIA
    |--------------------------------------------------------------------------
    */

    Asistencia::create([

        'clase_id' =>
            $qr->clase_id,

        'docente_id' =>
            $docenteId,

        'alumno_id' =>
            $alumno->id,

        'estado' =>
            'Asistencia',

        'codigo_qr' =>
            $qr->codigo,

        'fecha_hora' =>
            Carbon::now(),

        'latitud' =>
            $validated['latitud'],

        'longitud' =>
            $validated['longitud']

    ]);


    /*
    |--------------------------------------------------------------------------
    | RESPUESTA EXITOSA
    |--------------------------------------------------------------------------
    */

    return response()->make('
        <!DOCTYPE html>

        <html lang="es">

        <head>

            <meta charset="UTF-8">

            <meta
                name="viewport"
                content="width=device-width, initial-scale=1.0"
            >

            <title>Asistencia registrada</title>

            <style>

                body {
                    font-family: Arial, sans-serif;
                    background: #f3f4f6;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    min-height: 100vh;
                    margin: 0;
                }

                .card {
                    background: white;
                    padding: 45px;
                    border-radius: 25px;
                    box-shadow: 0 10px 30px rgba(0,0,0,.15);
                    text-align: center;
                    max-width: 450px;
                    margin: 20px;
                }

                .icon {
                    font-size: 65px;
                    margin-bottom: 15px;
                }

                h2 {
                    color: #16a34a;
                    margin-bottom: 15px;
                }

                p {
                    color: #555;
                    line-height: 1.6;
                }

                .alumno {
                    font-weight: bold;
                    color: #111827;
                }

            </style>

        </head>

        <body>

            <div class="card">

                <div class="icon">
                    ✅
                </div>

                <h2>
                    Asistencia registrada correctamente
                </h2>

                <p>
                    La asistencia del alumno
                </p>

                <p class="alumno">
                    ' . htmlspecialchars(
                        $alumno->nombre . ' ' .
                        $alumno->apellido_paterno
                    ) . '
                </p>

                <p>
                    fue registrada correctamente.
                </p>

                <p>
                    📍 La ubicación GPS fue guardada.
                </p>

                <p>
                    Puedes cerrar esta ventana.
                </p>

            </div>

        </body>

        </html>
    ');
}


    /*
    |--------------------------------------------------------------------------
    | CALCULAR DISTANCIA
    |--------------------------------------------------------------------------
    */

    private function calcularDistancia(
        $lat1,
        $lon1,
        $lat2,
        $lon2
    ) {

        $radio = 6371000;

        $dLat = deg2rad(
            $lat2 - $lat1
        );

        $dLon = deg2rad(
            $lon2 - $lon1
        );

        $a =
            sin($dLat / 2)
            *
            sin($dLat / 2)

            +

            cos(
                deg2rad($lat1)
            )

            *

            cos(
                deg2rad($lat2)
            )

            *

            sin($dLon / 2)
            *
            sin($dLon / 2);


        $c =
            2 *
            atan2(
                sqrt($a),
                sqrt(1 - $a)
            );


        return $radio * $c;
    }
}