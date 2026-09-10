<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model
{
    use HasFactory;

    protected $fillable = [
        'docente_id',
        'alumno_id',
        'clase_id',
        'estado',
        'codigo_qr',
        'fecha_hora',
        'latitud',
        'longitud'
    ];

    public function clase()
    {
        return $this->belongsTo(Clase::class);
    }

    public function docente()
    {
        return $this->belongsTo(Docente::class);
    }

    // Nueva relacion: Una asistencia pertenece a un alumno específico
    public function alumno()
    {
        return $this->belongsTo(Alumno::class);
    }
}