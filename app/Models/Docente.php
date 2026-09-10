<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Docente extends Model
{
    protected $fillable = [
        'numero_empleado',
        'nombre',
        'apellido_paterno',
        'apellido_materno',
        'correo',
        'telefono',
    ];

    public function horarios()
    {
        return $this->hasMany(Horario::class);
    }

    public function asistencias()
    {
        return $this->hasMany(Asistencia::class);
    }
}