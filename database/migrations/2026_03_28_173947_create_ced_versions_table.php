<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ced_version', function (Blueprint $table) {
            $table->id('ver_id');
            $table->enum('ver_act',['0','1'])->default('1');  ##### borrado lógico inactivo
            $table->enum('ver_del',['0','1'])->default('0'); ##### borrado lógico
            $table->foreignId('ver_cedid')->constrained('cedula_url','url_id'); ##### Id de la cédula
            $table->string('ver_version');
            $table->integer('ver_mes');
            $table->integer('ver_anio');
            $table->integer('ver_dia');
            $table->time('ver_hora');
            $table->longText('ver_pdf');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ced_version');
    }
};
