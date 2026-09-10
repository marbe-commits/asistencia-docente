<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('horarios', function (Blueprint $table) {

            $table->id();

            $table->foreignId('docente_id')
                  ->constrained('docentes')
                  ->onDelete('cascade');

            $table->foreignId('materia_id')
                  ->constrained('materias')
                  ->onDelete('cascade');

            $table->foreignId('grupo_id')
                  ->constrained('grupos')
                  ->onDelete('cascade');

            $table->foreignId('aula_id')
                  ->constrained('aulas')
                  ->onDelete('cascade');

            $table->enum('dia', [
                'Lunes',
                'Martes',
                'Miercoles',
                'Jueves',
                'Viernes',
                'Sabado'
            ]);

            $table->time('hora_inicio');

            $table->time('hora_fin');

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('horarios');
    }
};