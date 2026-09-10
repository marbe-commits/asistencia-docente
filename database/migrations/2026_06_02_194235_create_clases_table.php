<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('clases', function (Blueprint $table) {

            $table->id();

            $table->foreignId('horario_id')
                  ->constrained('horarios')
                  ->onDelete('cascade');

            $table->date('fecha');

            $table->string('qr_token')->unique();

            $table->boolean('activa')
                  ->default(true);

            $table->timestamps();

        });
    }

    public function down()
    {
        Schema::dropIfExists('clases');
    }
};