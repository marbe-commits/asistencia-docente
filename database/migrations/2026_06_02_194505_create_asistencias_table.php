<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('asistencias', function (Blueprint $table) {

            $table->id();

            $table->foreignId('clase_id')
                  ->constrained('clases')
                  ->onDelete('cascade');

            $table->foreignId('docente_id')
                  ->constrained('docentes')
                  ->onDelete('cascade');

            $table->dateTime('fecha_hora');

            $table->decimal('latitud', 10, 7);

            $table->decimal('longitud', 10, 7);

            $table->enum('estado', [
                'Asistencia',
                'Retardo',
                'Falta'
            ]);

            $table->timestamps();

        });
    }

    public function down()
    {
        Schema::dropIfExists('asistencias');
    }
};