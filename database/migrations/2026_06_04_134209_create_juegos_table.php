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
        Schema::create('juegos', function (Blueprint $table) {
            $table->id('jue_id');
            $table->enum('jue_act',['0','1'])->default('1');  ##### borrado lógico inactivo
            $table->enum('jue_del',['0','1'])->default('0'); ##### borrado lógico
            $table->string('jue_cjarsiglas'); #### Jardín al que pertenece
            $table->string('jue_tipo'); #### tipo: ('memoria','loteria','sopaletras')
            $table->string('jue_name'); ##### título
            $table->string('jue_portada')->nullable(); #### Ruta a imagen de portada

            $table->longText('jue_cita')->nullable(); ##### Cita completa del juego
            $table->longText('jue_cita_aut')->nullable(); ##### Autores en formato de cita
            $table->string('jue_anio')->nullable(); ##### Año de la cédula
            $table->decimal('jue_version',5 ,2)->default('1.0');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('juegos');
    }
};
