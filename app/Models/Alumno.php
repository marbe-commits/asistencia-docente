<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    use HasFactory;

    protected $fillable = [

        'matricula',

        'nombre',

        'apellido_paterno',

        'apellido_materno',

        'correo',

        'grupo_id'
    ];

    public function grupo()
    {
        return $this->belongsTo(Grupo::class);
    }
}