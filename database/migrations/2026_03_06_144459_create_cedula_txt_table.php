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
        Schema::create('cedula_txt', function (Blueprint $table) {
            $table->id('txt_id');
            $table->string('txt_cjarsiglas');     #### Tipo de cédula que se construye
            $table->foreignId('txt_urlid')->constrained('cedula_url','url_id');
            $table->string('txt_urlurl');     #### url de la cédula ej: huaje_huv
            // $table->foreign('txt_urlurl')->references('url_url')->on('cedula_url')->constrained('cedula_url','url_url');
            // $table->string('txt_urlurl');     #### Tipo de cédula que se construye
            // $table->foreign('txt_urlurl')->references('url_url')->on('cedula_url')->constrained('cedula_url','url_url');

            $table->enum('txt_act',['0','1'])->default('1');  ##### borrado lógico inactivo
            $table->enum('txt_del',['0','1'])->default('0'); ##### borrado lógico
            $table->string('txt_tipo')->default('p'); ##### Tipo de elemento (párrafo, h1, h2,autor,traductor)
            $table->decimal('txt_orden',5,2)->default('1');  ##### Orden en el que aparece la cédula

            $table->longText('txt_txt')->nullable(); ##### Texto del párrafo
            $table->longText('txt_txtoriginal')->nullable(); ##### Texto original
            $table->string('txt_audio')->nullable();  ##### Liga al audio del párrafo
            $table->decimal('txt_version',3,1)->default('1.0'); ##### versión del párrafo

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cedula_txt');
    }
};
