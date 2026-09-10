<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('codigos_qr', function (Blueprint $table) {

            $table->id();

            $table->foreignId('clase_id')
                  ->constrained()
                  ->onDelete('cascade');

            $table->string('codigo')->unique();

            $table->timestamp('fecha_expiracion');

            $table->boolean('activo')->default(true);

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('codigos_qr');
    }
};