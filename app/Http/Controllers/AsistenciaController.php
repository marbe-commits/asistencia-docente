<?php

namespace App\Http\Controllers;

use App\Models\Asistencia;
use App\Models\Clase;
use App\Models\Docente;
use App\Models\Grupo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AsistenciaController extends Controller
{
    /**
     * Mostrar asistencias.
     *
     * ADMINISTRADOR:
     * Puede ver todas las asistencias y utilizar los filtros.
     *
     * DOCENTE:
     * Solamente puede ver las asistencias de sus propias clases.
     */
    public function index(Request $request)
    {
        $usuario = Auth::user();

        /*
        |--------------------------------------------------------------------------
        | GRUPOS
        |--------------------------------------------------------------------------
        */

        $grupos = Grupo::orderBy('nombre')->get();


        /*
        |--------------------------------------------------------------------------
        | ADMINISTRADOR
        |--------------------------------------------------------------------------
        */

        if ($usuario->rol === 'administrador') {

            $docentes = Docente::orderBy('nombre')->get();

            $query = Asistencia::with([
                'alumno',
                'docente',
                'clase.horario.materia',
                'clase.horario.grupo'
            ]);


            /*
            | Filtro por profesor
            */

            if ($request->filled('docente_id')) {

                $query->where(
                    'docente_id',
                    $request->docente_id
                );
            }


            /*
            | Filtro por grupo
            */

            if ($request->filled('grupo_id')) {

                $query->whereHas(
                    'clase.horario',
                    function ($q) use ($request) {

                        $q->where(
                            'grupo_id',
                            $request->grupo_id
                        );
                    }
                );
            }
        }


        /*
        |--------------------------------------------------------------------------
        | DOCENTE
        |--------------------------------------------------------------------------
        */

        else {

            /*
            | Buscar docente relacionado con el usuario
            | mediante su correo electrónico.
            */

            $docente = Docente::where(
                'correo',
                $usuario->email
            )->first();


            if (!$docente) {

                return view('asistencias.index', [
                    'asistencias' => collect(),
                    'docentes' => collect(),
                    'grupos' => collect(),
                    'errorDocente' =>
                        'Tu usuario no está vinculado a un registro de docente.'
                ]);
            }


            /*
            | Solo mostrar el docente actual en los filtros
            */

            $docentes = collect([$docente]);


            /*
            |--------------------------------------------------------------------------
            | CONSULTA DEL DOCENTE
            |--------------------------------------------------------------------------
            |
            | La asistencia está relacionada así:
            |
            | Asistencia
            |      ↓
            |    Clase
            |      ↓
            |   Horario
            |      ↓
            |   Docente
            |
            */

            $query = Asistencia::with([
                'alumno',
                'docente',
                'clase.horario.materia',
                'clase.horario.grupo'
            ])
            ->whereHas(
                'clase.horario',
                function ($q) use ($docente) {

                    $q->where(
                        'docente_id',
                        $docente->id
                    );
                }
            );


            /*
            | Filtro por grupo para el docente
            */

            if ($request->filled('grupo_id')) {

                $query->whereHas(
                    'clase.horario',
                    function ($q) use ($request, $docente) {

                        $q->where(
                            'docente_id',
                            $docente->id
                        )
                        ->where(
                            'grupo_id',
                            $request->grupo_id
                        );
                    }
                );
            }
        }


        /*
        |--------------------------------------------------------------------------
        | OBTENER ASISTENCIAS
        |--------------------------------------------------------------------------
        */

        $asistencias = $query
            ->orderBy('fecha_hora', 'desc')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | VISTA
        |--------------------------------------------------------------------------
        */

        return view(
            'asistencias.index',
            compact(
                'asistencias',
                'docentes',
                'grupos'
            )
        );
    }


    /**
     * Mostrar formulario para crear asistencia.
     */
    public function create()
    {
        $usuario = Auth::user();


        /*
        |--------------------------------------------------------------------------
        | ADMINISTRADOR
        |--------------------------------------------------------------------------
        */

        if ($usuario->rol === 'administrador') {

            $clases = Clase::with([
                'horario.docente',
                'horario.materia',
                'horario.grupo'
            ])->get();

            $docentes = Docente::orderBy('nombre')->get();
        }


        /*
        |--------------------------------------------------------------------------
        | DOCENTE
        |--------------------------------------------------------------------------
        */

        else {

            $docente = Docente::where(
                'correo',
                $usuario->email
            )->first();


            if (!$docente) {

                abort(
                    403,
                    'Tu usuario no está vinculado a un docente.'
                );
            }


            /*
            | Solamente sus clases
            */

            $clases = Clase::with([
                'horario.docente',
                'horario.materia',
                'horario.grupo'
            ])
            ->whereHas(
                'horario',
                function ($q) use ($docente) {

                    $q->where(
                        'docente_id',
                        $docente->id
                    );
                }
            )
            ->get();


            /*
            | Solamente él mismo
            */

            $docentes = collect([$docente]);
        }


        return view(
            'asistencias.create',
            compact(
                'clases',
                'docentes'
            )
        );
    }


    /**
     * Guardar asistencia.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([

            'clase_id' => [
                'required',
                'exists:clases,id'
            ],

            'docente_id' => [
                'required',
                'exists:docentes,id'
            ],

            'estado' => [
                'required',
                'in:Asistencia,Retardo,Falta'
            ]

        ]);


        /*
        |--------------------------------------------------------------------------
        | SEGURIDAD PARA DOCENTE
        |--------------------------------------------------------------------------
        */

        if (Auth::user()->rol === 'docente') {

            $docente = Docente::where(
                'correo',
                Auth::user()->email
            )->first();


            if (!$docente) {

                abort(
                    403,
                    'Tu usuario no está vinculado a un docente.'
                );
            }


            /*
            | No puede registrar asistencia como otro docente
            */

            if (
                (int) $validated['docente_id'] !==
                (int) $docente->id
            ) {

                abort(
                    403,
                    'No puedes registrar asistencia para otro docente.'
                );
            }


            /*
            | La clase debe pertenecer al docente
            */

            $clasePertenece = Clase::where(
                'id',
                $validated['clase_id']
            )
            ->whereHas(
                'horario',
                function ($q) use ($docente) {

                    $q->where(
                        'docente_id',
                        $docente->id
                    );
                }
            )
            ->exists();


            if (!$clasePertenece) {

                abort(
                    403,
                    'No puedes registrar asistencia de una clase de otro docente.'
                );
            }
        }


        /*
        |--------------------------------------------------------------------------
        | CREAR ASISTENCIA
        |--------------------------------------------------------------------------
        */

        Asistencia::create([

            'clase_id' => $validated['clase_id'],

            'docente_id' => $validated['docente_id'],

            'fecha_hora' => now(),

            'latitud' => 19.432608,

            'longitud' => -99.133209,

            'estado' => $validated['estado']

        ]);


        return redirect()
            ->route('asistencias.index')
            ->with(
                'success',
                'Asistencia registrada correctamente.'
            );
    }


    /**
     * Mostrar formulario de edición.
     */
    public function edit(Asistencia $asistencia)
    {
        $usuario = Auth::user();


        /*
        |--------------------------------------------------------------------------
        | ADMINISTRADOR
        |--------------------------------------------------------------------------
        */

        if ($usuario->rol === 'administrador') {

            $clases = Clase::with([
                'horario.docente',
                'horario.materia',
                'horario.grupo'
            ])->get();

            $docentes = Docente::orderBy('nombre')->get();
        }


        /*
        |--------------------------------------------------------------------------
        | DOCENTE
        |--------------------------------------------------------------------------
        */

        else {

            $docente = Docente::where(
                'correo',
                $usuario->email
            )->first();


            if (!$docente) {

                abort(
                    403,
                    'Tu usuario no está vinculado a un docente.'
                );
            }


            /*
            | Verificar que la asistencia sea de una clase suya
            */

            $esSuAsistencia = Asistencia::where(
                'id',
                $asistencia->id
            )
            ->whereHas(
                'clase.horario',
                function ($q) use ($docente) {

                    $q->where(
                        'docente_id',
                        $docente->id
                    );
                }
            )
            ->exists();


            if (!$esSuAsistencia) {

                abort(
                    403,
                    'No tienes permiso para editar esta asistencia.'
                );
            }


            /*
            | Solamente sus clases
            */

            $clases = Clase::with([
                'horario.docente',
                'horario.materia',
                'horario.grupo'
            ])
            ->whereHas(
                'horario',
                function ($q) use ($docente) {

                    $q->where(
                        'docente_id',
                        $docente->id
                    );
                }
            )
            ->get();


            $docentes = collect([$docente]);
        }


        return view(
            'asistencias.edit',
            compact(
                'asistencia',
                'clases',
                'docentes'
            )
        );
    }


    /**
     * Actualizar asistencia.
     */
    public function update(
        Request $request,
        Asistencia $asistencia
    ) {

        $validated = $request->validate([

            'clase_id' => [
                'required',
                'exists:clases,id'
            ],

            'docente_id' => [
                'required',
                'exists:docentes,id'
            ],

            'estado' => [
                'required',
                'in:Asistencia,Retardo,Falta'
            ]

        ]);


        /*
        |--------------------------------------------------------------------------
        | SEGURIDAD PARA DOCENTE
        |--------------------------------------------------------------------------
        */

        if (Auth::user()->rol === 'docente') {

            $docente = Docente::where(
                'correo',
                Auth::user()->email
            )->first();


            if (!$docente) {

                abort(
                    403,
                    'Tu usuario no está vinculado a un docente.'
                );
            }


            /*
            | Verificar que la asistencia sea suya
            */

            $esSuAsistencia = Asistencia::where(
                'id',
                $asistencia->id
            )
            ->whereHas(
                'clase.horario',
                function ($q) use ($docente) {

                    $q->where(
                        'docente_id',
                        $docente->id
                    );
                }
            )
            ->exists();


            if (!$esSuAsistencia) {

                abort(
                    403,
                    'No tienes permiso para modificar esta asistencia.'
                );
            }


            /*
            | No puede cambiar el docente
            */

            $validated['docente_id'] = $docente->id;


            /*
            | La nueva clase también debe ser suya
            */

            $clasePertenece = Clase::where(
                'id',
                $validated['clase_id']
            )
            ->whereHas(
                'horario',
                function ($q) use ($docente) {

                    $q->where(
                        'docente_id',
                        $docente->id
                    );
                }
            )
            ->exists();


            if (!$clasePertenece) {

                abort(
                    403,
                    'No puedes asignar esta asistencia a una clase de otro docente.'
                );
            }
        }


        /*
        |--------------------------------------------------------------------------
        | ACTUALIZAR
        |--------------------------------------------------------------------------
        */

        $asistencia->update([

            'clase_id' => $validated['clase_id'],

            'docente_id' => $validated['docente_id'],

            'estado' => $validated['estado']

        ]);


        return redirect()
            ->route('asistencias.index')
            ->with(
                'success',
                'Asistencia actualizada correctamente.'
            );
    }


    /**
     * Eliminar asistencia.
     */
    public function destroy(Asistencia $asistencia)
    {
        /*
        |--------------------------------------------------------------------------
        | SEGURIDAD PARA DOCENTE
        |--------------------------------------------------------------------------
        */

        if (Auth::user()->rol === 'docente') {

            $docente = Docente::where(
                'correo',
                Auth::user()->email
            )->first();


            if (!$docente) {

                abort(
                    403,
                    'Tu usuario no está vinculado a un docente.'
                );
            }


            /*
            | Verificar que la asistencia pertenezca a una
            | clase del docente actual.
            */

            $esSuAsistencia = Asistencia::where(
                'id',
                $asistencia->id
            )
            ->whereHas(
                'clase.horario',
                function ($q) use ($docente) {

                    $q->where(
                        'docente_id',
                        $docente->id
                    );
                }
            )
            ->exists();


            if (!$esSuAsistencia) {

                abort(
                    403,
                    'No tienes permiso para eliminar esta asistencia.'
                );
            }
        }


        $asistencia->delete();


        return redirect()
            ->route('asistencias.index')
            ->with(
                'success',
                'Asistencia eliminada correctamente.'
            );
    }
}