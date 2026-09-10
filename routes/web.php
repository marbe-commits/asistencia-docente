<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DocenteController;
use App\Http\Controllers\MateriaController;
use App\Http\Controllers\GrupoController;
use App\Http\Controllers\AulaController;
use App\Http\Controllers\HorarioController;
use App\Http\Controllers\ClaseController;
use App\Http\Controllers\AsistenciaController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\CodigoQRController;


/*
|--------------------------------------------------------------------------
| PÁGINA PRINCIPAL
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});


/*
|--------------------------------------------------------------------------
| ASISTENCIA POR QR
|--------------------------------------------------------------------------
*/

Route::get(
    '/asistencia/{codigo}',
    [CodigoQRController::class, 'registrar']
)->name('qr.registrar');


Route::post(
    '/alumnos/asistencia',
    [AlumnoController::class, 'registrarAsistencia']
)->name('alumnos.registrar');


/*
|--------------------------------------------------------------------------
| DASHBOARD
|--------------------------------------------------------------------------
*/

Route::get(
    '/dashboard',
    [DashboardController::class, 'index']
)
->middleware(['auth', 'verified'])
->name('dashboard');


/*
|--------------------------------------------------------------------------
| RUTAS PROTEGIDAS
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {


    /*
    |--------------------------------------------------------------------------
    | SOLO ADMINISTRADOR
    |--------------------------------------------------------------------------
    */

    Route::middleware('role:administrador')->group(function () {


        /*
        |--------------------------------------------------------------------------
        | DOCENTES
        |--------------------------------------------------------------------------
        */

        // IMPORTACIÓN MASIVA
        Route::get(
            '/docentes/plantilla',
            [DocenteController::class, 'descargarPlantilla']
        )->name('docentes.plantilla');

        Route::post(
            '/docentes/importar',
            [DocenteController::class, 'importar']
        )->name('docentes.importar');

        // CRUD DOCENTES
        Route::resource(
            'docentes',
            DocenteController::class
        );


        /*
        |--------------------------------------------------------------------------
        | MATERIAS
        |--------------------------------------------------------------------------
        */

        // IMPORTACIÓN MASIVA
        Route::get(
            '/materias/plantilla',
            [MateriaController::class, 'descargarPlantilla']
        )->name('materias.plantilla');

        Route::post(
            '/materias/importar',
            [MateriaController::class, 'importar']
        )->name('materias.importar');

        // CRUD MATERIAS
        Route::resource(
            'materias',
            MateriaController::class
        );


        /*
        |--------------------------------------------------------------------------
        | GRUPOS
        |--------------------------------------------------------------------------
        */

        // IMPORTACIÓN MASIVA
        // IMPORTANTE: estas rutas van ANTES del resource

        Route::get(
            '/grupos/descargar-plantilla',
            [GrupoController::class, 'descargarPlantilla']
        )->name('grupos.plantilla');

        Route::post(
            '/grupos/importar',
            [GrupoController::class, 'importar']
        )->name('grupos.importar');

        // CRUD GRUPOS
        Route::resource(
            'grupos',
            GrupoController::class
        );


        /*
        |--------------------------------------------------------------------------
        | ALUMNOS
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/alumnos/escanear',
            [AlumnoController::class, 'escanear']
        )->name('alumnos.escanear');


        Route::get(
            '/alumnos/plantilla',
            [AlumnoController::class, 'descargarPlantilla']
        )->name('alumnos.plantilla');


        Route::post(
            '/alumnos/importar',
            [AlumnoController::class, 'importar']
        )->name('alumnos.importar');


        Route::get(
            '/alumnos/exportar',
            [AlumnoController::class, 'exportar']
        )->name('alumnos.exportar');


        Route::resource(
            'alumnos',
            AlumnoController::class
        );


        /*
        |--------------------------------------------------------------------------
        | AULAS
        |--------------------------------------------------------------------------
        */

        // IMPORTACIÓN MASIVA
        Route::get(
            '/aulas/plantilla',
            [AulaController::class, 'descargarPlantilla']
        )->name('aulas.plantilla');

        Route::post(
            '/aulas/importar',
            [AulaController::class, 'importar']
        )->name('aulas.importar');

        // CRUD AULAS
        Route::resource(
            'aulas',
            AulaController::class
        );

    });


    /*
    |--------------------------------------------------------------------------
    | ADMINISTRADOR Y DOCENTE
    |--------------------------------------------------------------------------
    */

    Route::middleware('role:administrador,docente')->group(function () {


        /*
        |--------------------------------------------------------------------------
        | HORARIOS
        |--------------------------------------------------------------------------
        */

        Route::resource(
            'horarios',
            HorarioController::class
        );


        /*
        |--------------------------------------------------------------------------
        | CLASES
        |--------------------------------------------------------------------------
        */

        Route::resource(
            'clases',
            ClaseController::class
        );


        /*
        |--------------------------------------------------------------------------
        | LISTA DE ASISTENCIA POR CLASE
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/reportes/asistencias/clase/{clase}',
            [ReporteController::class, 'formularioAsistencias']
        )->name('reportes.asistencias.form');


        Route::get(
            '/reportes/asistencias/clase/{clase}/descargar',
            [ReporteController::class, 'descargarAsistencias']
        )->name('reportes.asistencias.descargar');


        /*
        |--------------------------------------------------------------------------
        | ASISTENCIAS
        |--------------------------------------------------------------------------
        */

        Route::resource(
            'asistencias',
            AsistenciaController::class
        );


        /*
        |--------------------------------------------------------------------------
        | REPORTE GENERAL
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/reportes/asistencias/pdf',
            [ReporteController::class, 'asistenciasPdf']
        )->name('reportes.asistencias.pdf');


        /*
        |--------------------------------------------------------------------------
        | REPORTE POR PROFESOR
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/reportes/asistencias/profesor',
            [ReporteController::class, 'asistenciasPdf']
        )->name('reportes.asistencias.profesor');

    });


    /*
    |--------------------------------------------------------------------------
    | SOLO DOCENTE
    |--------------------------------------------------------------------------
    */

    Route::middleware('role:docente')->group(function () {


        /*
        |--------------------------------------------------------------------------
        | GENERAR QR
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/qr/generar/{id}',
            [CodigoQRController::class, 'generar']
        )->name('qr.generar');


        /*
        |--------------------------------------------------------------------------
        | ACTUALIZAR QR
        |--------------------------------------------------------------------------
        */

        Route::post(
            '/qr/{id}/actualizar',
            [CodigoQRController::class, 'actualizar']
        )->name('qr.actualizar');


        /*
        |--------------------------------------------------------------------------
        | FINALIZAR QR
        |--------------------------------------------------------------------------
        */

        Route::post(
            '/qr/{id}/finalizar',
            [CodigoQRController::class, 'finalizar']
        )->name('qr.finalizar');

    });


    /*
    |--------------------------------------------------------------------------
    | PERFIL
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/profile',
        [ProfileController::class, 'edit']
    )->name('profile.edit');


    Route::patch(
        '/profile',
        [ProfileController::class, 'update']
    )->name('profile.update');


    Route::delete(
        '/profile',
        [ProfileController::class, 'destroy']
    )->name('profile.destroy');

});


/*
|--------------------------------------------------------------------------
| AUTENTICACIÓN
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';