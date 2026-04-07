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
        Schema::create('autor_txt', function (Blueprint $table) {
            $table->id('autxt_id');
            $table->string('autxt_cjarsiglas');     #### Tipo de cédula que se construye
            $table->foreignId('autxt_cautid')->constrained('cat_autores','caut_id');
            $table->string('autxt_cauturl');     #### url de la cédula ej: huaje_huv
            $table->string('autxt_key')->nullable();

            $table->enum('autxt_act',['0','1'])->default('1');  ##### borrado lógico inactivo
            $table->enum('autxt_del',['0','1'])->default('0'); ##### borrado lógico
            $table->string('autxt_tipo')->default('p'); ##### Tipo de elemento (párrafo, h1, h2,autor,traductor)
            $table->decimal('autxt_orden',5,2)->default('1');  ##### Orden en el que aparece la cédula

            $table->longText('autxt_txt')->nullable(); ##### Texto del párrafo
            $table->longText('autxt_txtoriginal')->nullable(); ##### Texto original
            $table->string('autxt_audio')->nullable();  ##### Liga al audio del párrafo
            $table->decimal('autxt_version',3,1)->default('1.0'); ##### versión del párrafo
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('autor_txt');
    }
};
