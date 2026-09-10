<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clase extends Model
{
    use HasFactory;

    protected $fillable = [
        'horario_id',
        'fecha',
        'qr_token',
        'activa',
    ];

    protected $casts = [
        'fecha' => 'date',
        'activa' => 'boolean',
    ];

    public function horario()
    {
        return $this->belongsTo(Horario::class);
    }

    public function asistencias()
    {
        return $this->hasMany(Asistencia::class);
    }
}