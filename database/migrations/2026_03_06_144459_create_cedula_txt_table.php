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
            $table->id('ced_id');
            $table->integer('ced_urlid');     #### Tipo de cédula que se construye
            $table->foreign('ced_urlid')->references('url_id')->on('cedula_url')->constrained('cedula_url','url_id');
            $table->string('ced_cjarsiglas');     #### Tipo de cédula que se construye
            // $table->foreign('ced_cjarsiglas')->references('url_cjarsiglas')->on('cedula_url')->constrained('cedula_url','url_cjarsiglas');
            $table->string('ced_urlurl');     #### Tipo de cédula que se construye
            // $table->foreign('ced_urlurl')->references('url_url')->on('cedula_url')->constrained('cedula_url','url_url');

            $table->enum('ced_act',['0','1'])->default('1');  ##### borrado lógico inactivo
            $table->enum('ced_del',['0','1'])->default('0'); ##### borrado lógico
            $table->decimal('ced_orden',5,2)->default('1');  ##### Orden en el que aparece la cédula

            $table->longText('ced_txt')->nullable(); ##### Texto del párrafo
            $table->longText('ced_txtoriginal')->nullable(); ##### Texto original
            $table->string('ced_audio')->nullable();  ##### Liga al audio del párrafo
            $table->decimal('ced_version',5,2)->default('1.0'); ##### versión del párrafo

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
