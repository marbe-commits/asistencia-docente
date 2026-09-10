<?php

namespace App\Http\Controllers;

use App\Models\Clase;
use App\Models\Horario;
use App\Models\Docente;
use App\Models\Materia;
use App\Models\Grupo;
use App\Models\Aula;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ClaseController extends Controller
{
    /**
     * Obtener el docente relacionado con el usuario actual.
     *
     * IMPORTANTE:
     * La tabla docentes se relaciona mediante el correo.
     */
    private function docenteActual()
    {
        $usuario = Auth::user();

        if (!$usuario) {
            return null;
        }

        return Docente::where('correo', $usuario->email)->first();
    }

    /**
     * LISTADO DE CLASES
     */
    public function index()
    {
        $usuario = Auth::user();

        if (!$usuario) {
            return redirect()->route('login');
        }

        /*
        |--------------------------------------------------------------------------
        | ADMINISTRADOR
        |--------------------------------------------------------------------------
        */

        if ($usuario->rol === 'administrador') {

            $clases = Clase::with([
                'horario.docente',
                'horario.materia',
                'horario.grupo',
                'horario.aula'
            ])
            ->orderBy('fecha', 'desc')
            ->orderBy('id', 'desc')
            ->get();

            return view('clases.index', compact('clases'));
        }

        /*
        |--------------------------------------------------------------------------
        | DOCENTE
        |--------------------------------------------------------------------------
        */

        if ($usuario->rol === 'docente') {

            $docente = $this->docenteActual();

            /*
             * Si no existe el docente, NO mandamos al dashboard.
             * Mostramos un mensaje claro.
             */

            if (!$docente) {
                return view('clases.index', [
                    'clases' => collect(),
                    'errorDocente' => 'Tu usuario no está vinculado a un registro de docente. El correo del usuario debe coincidir con el campo correo de la tabla docentes.'
                ]);
            }

            /*
             * SOLO las clases de este docente
             */

            $clases = Clase::with([
                'horario.docente',
                'horario.materia',
                'horario.grupo',
                'horario.aula'
            ])
            ->whereHas('horario', function ($query) use ($docente) {
                $query->where('docente_id', $docente->id);
            })
            ->orderBy('fecha', 'desc')
            ->orderBy('id', 'desc')
            ->get();

            return view('clases.index', compact('clases'));
        }

        abort(403, 'Rol no autorizado.');
    }

    /**
     * FORMULARIO PARA CREAR UNA CLASE
     */
    public function create()
    {
        $usuario = Auth::user();

        if (!$usuario) {
            return redirect()->route('login');
        }

        /*
        |--------------------------------------------------------------------------
        | ADMINISTRADOR
        |--------------------------------------------------------------------------
        */

        if ($usuario->rol === 'administrador') {

            $horarios = Horario::with([
                'docente',
                'materia',
                'grupo',
                'aula'
            ])
            ->orderBy('id', 'desc')
            ->get();

        }

        /*
        |--------------------------------------------------------------------------
        | DOCENTE
        |--------------------------------------------------------------------------
        */

        elseif ($usuario->rol === 'docente') {

            $docente = $this->docenteActual();

            if (!$docente) {

                return redirect()
                    ->route('clases.index')
                    ->with(
                        'error',
                        'No se encontró un docente relacionado con tu correo: ' . $usuario->email
                    );
            }

            $horarios = Horario::with([
                'docente',
                'materia',
                'grupo',
                'aula'
            ])
            ->where('docente_id', $docente->id)
            ->orderBy('dia')
            ->orderBy('hora_inicio')
            ->get();

        }

        else {
            abort(403, 'Rol no autorizado.');
        }

        /*
        |--------------------------------------------------------------------------
        | CATÁLOGOS PARA EL FORMULARIO
        |--------------------------------------------------------------------------
        */

        $materias = Materia::orderBy('nombre')->get();
        $grupos   = Grupo::orderBy('nombre')->get();
        $aulas    = Aula::orderBy('nombre')->get();

        return view('clases.create', compact(
            'horarios',
            'materias',
            'grupos',
            'aulas'
        ));
    }

    /**
     * GUARDAR CLASE
     */
    public function store(Request $request)
    {
        $usuario = Auth::user();

        if (!$usuario) {
            return redirect()->route('login');
        }

        $request->validate([
            'horario_id' => 'required|exists:horarios,id',
            'fecha' => 'required|date',
        ], [
            'horario_id.required' => 'Debes seleccionar un horario.',
            'horario_id.exists' => 'El horario seleccionado no existe.',
            'fecha.required' => 'Debes seleccionar la fecha de la clase.',
            'fecha.date' => 'La fecha no es válida.',
        ]);

        /*
        |--------------------------------------------------------------------------
        | OBTENER HORARIO
        |--------------------------------------------------------------------------
        */

        $horario = Horario::with([
            'docente',
            'materia',
            'grupo',
            'aula'
        ])->findOrFail($request->horario_id);

        /*
        |--------------------------------------------------------------------------
        | VALIDAR DOCENTE
        |--------------------------------------------------------------------------
        */

        if ($usuario->rol === 'docente') {

            $docente = $this->docenteActual();

            if (!$docente) {

                return redirect()
                    ->route('clases.index')
                    ->with(
                        'error',
                        'Tu cuenta no está vinculada a un docente.'
                    );
            }

            if ($horario->docente_id != $docente->id) {

                abort(
                    403,
                    'No puedes crear una clase utilizando el horario de otro docente.'
                );
            }
        }

        /*
        |--------------------------------------------------------------------------
        | CREAR CLASE
        |--------------------------------------------------------------------------
        */

        $clase = Clase::create([
            'horario_id' => $horario->id,
            'fecha' => $request->fecha,
            'qr_token' => Str::random(40),
            'activa' => true,
        ]);

        return redirect()
            ->route('clases.index')
            ->with(
                'success',
                'La clase fue creada correctamente.'
            );
    }

    /**
     * EDITAR CLASE
     */
    public function edit(Clase $clase)
    {
        $usuario = Auth::user();

        if (!$usuario) {
            return redirect()->route('login');
        }

        $clase->load([
            'horario.docente',
            'horario.materia',
            'horario.grupo',
            'horario.aula'
        ]);

        /*
        |--------------------------------------------------------------------------
        | DOCENTE
        |--------------------------------------------------------------------------
        */

        if ($usuario->rol === 'docente') {

            $docente = $this->docenteActual();

            if (!$docente) {
                return redirect()
                    ->route('clases.index')
                    ->with(
                        'error',
                        'Tu cuenta no está vinculada a un docente.'
                    );
            }

            if (
                !$clase->horario ||
                $clase->horario->docente_id != $docente->id
            ) {
                abort(
                    403,
                    'No tienes permiso para modificar esta clase.'
                );
            }

            $horarios = Horario::with([
                'docente',
                'materia',
                'grupo',
                'aula'
            ])
            ->where('docente_id', $docente->id)
            ->orderBy('dia')
            ->orderBy('hora_inicio')
            ->get();

        } else {

            $horarios = Horario::with([
                'docente',
                'materia',
                'grupo',
                'aula'
            ])
            ->orderBy('dia')
            ->orderBy('hora_inicio')
            ->get();
        }

        return view(
            'clases.edit',
            compact('clase', 'horarios')
        );
    }

    /**
     * ACTUALIZAR CLASE
     */
    public function update(Request $request, Clase $clase)
    {
        $request->validate([
            'horario_id' => 'required|exists:horarios,id',
            'fecha' => 'required|date',
        ]);

        $usuario = Auth::user();

        $horario = Horario::findOrFail($request->horario_id);

        /*
        |--------------------------------------------------------------------------
        | VALIDAR DOCENTE
        |--------------------------------------------------------------------------
        */

        if ($usuario->rol === 'docente') {

            $docente = $this->docenteActual();

            if (!$docente) {
                return redirect()
                    ->route('clases.index')
                    ->with(
                        'error',
                        'Tu cuenta no está vinculada a un docente.'
                    );
            }

            if (
                !$clase->horario ||
                $clase->horario->docente_id != $docente->id
            ) {
                abort(
                    403,
                    'No tienes permiso para modificar esta clase.'
                );
            }

            if ($horario->docente_id != $docente->id) {
                abort(
                    403,
                    'No puedes asignar esta clase al horario de otro docente.'
                );
            }
        }

        /*
        |--------------------------------------------------------------------------
        | ACTUALIZAR
        |--------------------------------------------------------------------------
        */

        $clase->update([
            'horario_id' => $horario->id,
            'fecha' => $request->fecha,
        ]);

        return redirect()
            ->route('clases.index')
            ->with(
                'success',
                'La clase fue actualizada correctamente.'
            );
    }

    /**
     * ELIMINAR CLASE
     */
    public function destroy(Clase $clase)
    {
        $usuario = Auth::user();

        if (!$usuario) {
            return redirect()->route('login');
        }

        /*
        |--------------------------------------------------------------------------
        | DOCENTE
        |--------------------------------------------------------------------------
        */

        if ($usuario->rol === 'docente') {

            $docente = $this->docenteActual();

            if (!$docente) {

                return redirect()
                    ->route('clases.index')
                    ->with(
                        'error',
                        'Tu cuenta no está vinculada a un docente.'
                    );
            }

            $clase->load('horario');

            if (
                !$clase->horario ||
                $clase->horario->docente_id != $docente->id
            ) {
                abort(
                    403,
                    'No tienes permiso para eliminar esta clase.'
                );
            }
        }

        $clase->delete();

        return redirect()
            ->route('clases.index')
            ->with(
                'success',
                'La clase fue eliminada correctamente.'
            );
    }
}