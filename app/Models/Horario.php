<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    use HasFactory;

    protected $fillable = [
        'docente_id',
        'materia_id',
        'grupo_id',
        'aula_id',
        'dia',
        'fecha',
        'hora_inicio',
        'hora_fin',
    ];

    public function docente()
    {
        return $this->belongsTo(Docente::class);
    }

    public function materia()
    {
        return $this->belongsTo(Materia::class);
    }

    public function grupo()
    {
        return $this->belongsTo(Grupo::class);
    }

    public function aula()
    {
        return $this->belongsTo(Aula::class);
    }

    public function clases()
    {
        return $this->hasMany(Clase::class);
    }
}