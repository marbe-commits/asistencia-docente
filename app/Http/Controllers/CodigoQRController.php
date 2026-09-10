<?php

namespace App\Http\Controllers;

use App\Models\Clase;
use App\Models\CodigoQR;
use App\Models\Asistencia;
use Illuminate\Support\Str;

class CodigoQRController extends Controller
{
    public function generar($id)
    {
        $clase = Clase::with([
            'horario.docente',
            'horario.materia',
            'horario.grupo',
            'horario.aula'
        ])->findOrFail($id);

        // Buscar QR activo
        $codigoQR = CodigoQR::where('clase_id', $clase->id)
            ->where('activo', 1)
            ->first();

        // Si no existe lo crea
        if (!$codigoQR) {

            $codigoQR = CodigoQR::create([
                'clase_id'   => $clase->id,
                'codigo'     => Str::random(20),
                'expiracion' => now()->addMinutes(2),
                'activo'     => true
            ]);

        }

        $asistencias = Asistencia::with('alumno')
            ->where('clase_id', $clase->id)
            ->orderBy('fecha_hora', 'DESC')
            ->get();

        return view(
            'qr.mostrar',
            compact(
                'clase',
                'codigoQR',
                'asistencias'
            )
        );
    }

    // ACTUALIZAR QR
    public function actualizar($id)
    {
        $qr = CodigoQR::findOrFail($id);

        $qr->update([
            'codigo'     => Str::random(20),
            'expiracion' => now()->addMinutes(2),
            'activo'     => true
        ]);

        return redirect()
            ->route('qr.generar', $qr->clase_id)
            ->with('success', 'C¨®digo QR actualizado correctamente.');
    }

    // FINALIZAR CLASE
    public function finalizar($id)
    {
        $qr = CodigoQR::findOrFail($id);

        $qr->update([
            'activo' => false
        ]);

        return redirect()
            ->route('clases.index')
            ->with('success', 'Clase finalizada correctamente.');
    }

    // REGISTRAR DESDE EL CELULAR
    public function registrar($codigo)
    {
        $qr = CodigoQR::where('codigo', $codigo)
            ->where('activo', 1)
            ->first();

        if (!$qr) {
            return "QR inv¨¢lido o expirado.";
        }

        return view('alumnos.registrar', compact('qr'));
    }
}