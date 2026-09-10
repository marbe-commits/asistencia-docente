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
        Schema::create('docentes', function (Blueprint $table) {

            $table->id();

            $table->string('numero_empleado')->unique();

            $table->string('nombre');

            $table->string('apellido_paterno');

            $table->string('apellido_materno');

            $table->string('correo')->unique();

            $table->string('telefono')->nullable();

            $table->boolean('activo')->default(true);

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
        Schema::dropIfExists('docentes');
    }
};