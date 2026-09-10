<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materia extends Model
{
    use HasFactory;

    protected $fillable = [
        'clave',
        'nombre',
        'cuatrimestre',
        'descripcion'
    ];

    public function horarios()
    {
        return $this->hasMany(Horario::class);
    }
}