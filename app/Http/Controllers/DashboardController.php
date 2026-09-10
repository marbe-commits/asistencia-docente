<?php

namespace App\Http\Controllers;

use App\Models\Docente;
use App\Models\Materia;
use App\Models\Grupo;
use App\Models\Aula;
use App\Models\Horario;
use App\Models\Clase;
use App\Models\Asistencia;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $usuario = Auth::user();

        /*
        |--------------------------------------------------------------------------
        | ADMINISTRADOR
        |--------------------------------------------------------------------------
        */

        if ($usuario->rol === 'administrador') {

            $totalDocentes = Docente::count();
            $totalMaterias = Materia::count();
            $totalGrupos = Grupo::count();
            $totalAulas = Aula::count();
            $totalHorarios = Horario::count();
            $totalClases = Clase::count();

            $totalAsistencias = Asistencia::where(
                'estado',
                'Asistencia'
            )->count();

            $totalRetardos = Asistencia::where(
                'estado',
                'Retardo'
            )->count();

            $totalFaltas = Asistencia::where(
                'estado',
                'Falta'
            )->count();

            $ultimasAsistencias = Asistencia::latest()
                ->take(5)
                ->get();

            return view('dashboard', compact(
                'totalDocentes',
                'totalMaterias',
                'totalGrupos',
                'totalAulas',
                'totalHorarios',
                'totalClases',
                'totalAsistencias',
                'totalRetardos',
                'totalFaltas',
                'ultimasAsistencias'
            ));
        }


        /*
        |--------------------------------------------------------------------------
        | DOCENTE
        |--------------------------------------------------------------------------
        */

        if ($usuario->rol === 'docente') {

            return view('docentes.dashboard');
        }


        /*
        |--------------------------------------------------------------------------
        | ROL NO AUTORIZADO
        |--------------------------------------------------------------------------
        */

        abort(403, 'Rol no autorizado.');
    }
}