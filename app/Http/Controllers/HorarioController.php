<?php

namespace App\Http\Controllers;

use App\Models\Horario;
use App\Models\Docente;
use App\Models\Materia;
use App\Models\Grupo;
use App\Models\Aula;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class HorarioController extends Controller
{
    public function index()
    {
        $usuario = Auth::user();

        // ADMINISTRADOR: puede ver todos los horarios
        if ($usuario->rol === 'administrador') {

            $horarios = Horario::with([
                'docente',
                'materia',
                'grupo',
                'aula'
            ])->get();

        } else {

            // DOCENTE: buscar su registro mediante el correo
            $docente = Docente::where(
                'correo',
                $usuario->email
            )->first();

            if (!$docente) {
                return view('horarios.index', [
                    'horarios' => collect(),
                    'errorDocente' => 'Tu usuario no está vinculado a un registro de docente.'
                ]);
            }

            // DOCENTE: solamente sus horarios
            $horarios = Horario::with([
                'docente',
                'materia',
                'grupo',
                'aula'
            ])
            ->where('docente_id', $docente->id)
            ->get();
        }

        return view('horarios.index', compact('horarios'));
    }


    public function create()
    {
        $materias = Materia::all();
        $grupos = Grupo::all();
        $aulas = Aula::all();

        // ADMINISTRADOR: puede seleccionar cualquier docente
        if (Auth::user()->rol === 'administrador') {

            $docentes = Docente::all();

        } else {

            // DOCENTE: solamente puede trabajar con su propio registro
            $docente = Docente::where(
                'correo',
                Auth::user()->email
            )->first();

            $docentes = $docente
                ? collect([$docente])
                : collect();
        }

        return view('horarios.create', compact(
            'docentes',
            'materias',
            'grupos',
            'aulas'
        ));
    }


    public function store(Request $request)
    {
        $request->validate([
            'docente_id' => 'required|exists:docentes,id',
            'materia_id' => 'required|exists:materias,id',
            'grupo_id'   => 'required|exists:grupos,id',
            'aula_id'    => 'required|exists:aulas,id',

            'clases' => 'required|array|min:1|max:5',

            'clases.*.fecha' => 'required|date',

            'clases.*.hora_inicio' => 'required|date_format:H:i',

            'clases.*.hora_fin' => [
                'required',
                'date_format:H:i'
            ],
        ], [
            'clases.required' => 'Debes seleccionar cuántas clases impartes a la semana.',
            'clases.min' => 'Debes registrar al menos una clase.',
            'clases.max' => 'Puedes registrar máximo 5 clases por semana.',
            'clases.*.fecha.required' => 'La fecha de la clase es obligatoria.',
            'clases.*.hora_inicio.required' => 'La hora de inicio es obligatoria.',
            'clases.*.hora_fin.required' => 'La hora de fin es obligatoria.',
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

            // Un docente no puede crear horarios para otro docente
            if ((int) $request->docente_id !== (int) $docente->id) {
                abort(
                    403,
                    'No puedes crear un horario para otro docente.'
                );
            }
        }


        DB::beginTransaction();

        try {

            $dias = [
                'Monday'    => 'Lunes',
                'Tuesday'   => 'Martes',
                'Wednesday' => 'Miercoles',
                'Thursday'  => 'Jueves',
                'Friday'    => 'Viernes',
                'Saturday'  => 'Sabado',
                'Sunday'    => 'Domingo'
            ];


            foreach ($request->clases as $clase) {

                // Verificar que la hora final sea posterior
                if ($clase['hora_fin'] <= $clase['hora_inicio']) {

                    DB::rollBack();

                    return back()
                        ->withInput()
                        ->withErrors([
                            'clases' => 'La hora de fin debe ser posterior a la hora de inicio.'
                        ]);
                }


                $diaIngles = date(
                    'l',
                    strtotime($clase['fecha'])
                );

                $dia = $dias[$diaIngles];


                Horario::create([
                    'docente_id'  => $request->docente_id,
                    'materia_id'  => $request->materia_id,
                    'grupo_id'    => $request->grupo_id,
                    'aula_id'     => $request->aula_id,
                    'fecha'       => $clase['fecha'],
                    'dia'         => $dia,
                    'hora_inicio' => $clase['hora_inicio'],
                    'hora_fin'    => $clase['hora_fin'],
                ]);
            }


            DB::commit();


            return redirect()
                ->route('horarios.index')
                ->with(
                    'success',
                    'Horario registrado correctamente.'
                );

        } catch (\Exception $e) {

            DB::rollBack();

            return back()
                ->withInput()
                ->withErrors([
                    'error' =>
                        'Ocurrió un error al guardar el horario: '
                        . $e->getMessage()
                ]);
        }
    }


    public function edit(Horario $horario)
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

            if (
                !$docente ||
                (int) $horario->docente_id !== (int) $docente->id
            ) {
                abort(
                    403,
                    'No tienes permiso para editar este horario.'
                );
            }
        }


        $materias = Materia::all();
        $grupos = Grupo::all();
        $aulas = Aula::all();


        // ADMINISTRADOR puede seleccionar cualquier docente
        if (Auth::user()->rol === 'administrador') {

            $docentes = Docente::all();

        } else {

            // DOCENTE solamente puede seleccionar su propio registro
            $docente = Docente::where(
                'correo',
                Auth::user()->email
            )->first();

            $docentes = $docente
                ? collect([$docente])
                : collect();
        }


        return view('horarios.edit', compact(
            'horario',
            'docentes',
            'materias',
            'grupos',
            'aulas'
        ));
    }


    public function update(Request $request, Horario $horario)
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

            if (
                !$docente ||
                (int) $horario->docente_id !== (int) $docente->id
            ) {
                abort(
                    403,
                    'No tienes permiso para modificar este horario.'
                );
            }

            // El docente solamente puede actualizar su propio horario
            $request->merge([
                'docente_id' => $docente->id
            ]);
        }


        $request->validate([
            'docente_id'  => 'required|exists:docentes,id',
            'materia_id'  => 'required|exists:materias,id',
            'grupo_id'    => 'required|exists:grupos,id',
            'aula_id'     => 'required|exists:aulas,id',
            'fecha'       => 'required|date',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin'    => 'required|date_format:H:i',
        ]);


        // Verificar hora
        if ($request->hora_fin <= $request->hora_inicio) {

            return back()
                ->withInput()
                ->withErrors([
                    'hora_fin' =>
                        'La hora de fin debe ser posterior a la hora de inicio.'
                ]);
        }


        $dias = [
            'Monday'    => 'Lunes',
            'Tuesday'   => 'Martes',
            'Wednesday' => 'Miercoles',
            'Thursday'  => 'Jueves',
            'Friday'    => 'Viernes',
            'Saturday'  => 'Sabado',
            'Sunday'    => 'Domingo'
        ];


        $dia = $dias[
            date('l', strtotime($request->fecha))
        ];


        $horario->update([
            'docente_id'  => $request->docente_id,
            'materia_id'  => $request->materia_id,
            'grupo_id'    => $request->grupo_id,
            'aula_id'     => $request->aula_id,
            'fecha'       => $request->fecha,
            'dia'         => $dia,
            'hora_inicio' => $request->hora_inicio,
            'hora_fin'    => $request->hora_fin,
        ]);


        return redirect()
            ->route('horarios.index')
            ->with(
                'success',
                'Horario actualizado correctamente.'
            );
    }


    public function destroy(Horario $horario)
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

            if (
                !$docente ||
                (int) $horario->docente_id !== (int) $docente->id
            ) {
                abort(
                    403,
                    'No tienes permiso para eliminar este horario.'
                );
            }
        }


        $horario->delete();


        return redirect()
            ->route('horarios.index')
            ->with(
                'success',
                'Horario eliminado correctamente.'
            );
    }
}