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
        Schema::create('lista_txt', function (Blueprint $table) {


            $table->id('lstxt_id');
            $table->enum('lstxt_act',['0','1'])->default('1');  ##### borrado lógico inactivo
            $table->enum('lstxt_del',['0','1'])->default('0'); ##### borrado lógico
            $table->string('lstxt_cjarsiglas');     #### jardin
            // $table->string('lstxt_posicion')->default('up'); ##### Posición donde aparece el texto (up o down)
            $table->string('lstxt_tipo')->default('p'); ##### Tipo de elemento (párrafo, h1, h2,autor,traductor)
            $table->decimal('lstxt_orden',5,2)->default('1');  ##### Orden en el que aparece la cédula

            $table->longText('lstxt_txt')->nullable(); ##### Texto del párrafo (código html)
            $table->longText('lstxt_txtoriginal')->nullable(); ##### Texto original
            $table->string('lstxt_audio')->nullable();  ##### Liga al audio del párrafo
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lista_txt');
    }
};
