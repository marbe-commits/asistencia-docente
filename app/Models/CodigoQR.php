<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CodigoQR extends Model
{
    use HasFactory;

    protected $table = 'codigo_qrs';

    protected $fillable = [

        'clase_id',

        'codigo',

        'activo',

        'expiracion'

    ];

    public function clase()
    {
        return $this->belongsTo(Clase::class);
    }
}