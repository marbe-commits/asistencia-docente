<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('asistencias', function (Blueprint $table) {

            $table->foreignId('alumno_id')
                  ->nullable()
                  ->after('docente_id')
                  ->constrained('alumnos')
                  ->onDelete('cascade');

        });
    }

    public function down()
    {
        Schema::table('asistencias', function (Blueprint $table) {

            $table->dropForeign(['alumno_id']);

            $table->dropColumn('alumno_id');

        });
    }
};