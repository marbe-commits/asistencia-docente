<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aula extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'edificio',
        'capacidad',
        'activa'
    ];

    public function horarios()
    {
        return $this->hasMany(Horario::class);
    }
}