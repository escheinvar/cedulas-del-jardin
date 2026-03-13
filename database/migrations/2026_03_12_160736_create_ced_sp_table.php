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
        Schema::create('ced_sp', function (Blueprint $table) {
            $table->id('sp_id');
            $table->enum('sp_act',['0','1'])->default('1');  ##### borrado lógico inactivo
            $table->enum('sp_del',['0','1'])->default('0'); ##### borrado lógico
            $table->string('sp_cjarsiglas');     #### Jardín al que pertenece
            $table->string('sp_urlurl');     #### url de la cédula ej: huaje_huv

            $table->string('sp_scname');  ##### Nombre científico
            $table->enum('sp_reino',['planta','animal','fungi','bacteria','protista','arquea'])->default('planta');
            $table->string('sp_familia')->nullable();
            $table->string('sp_genero')->nullable();
            $table->string('sp_especie')->nullable();
            $table->string('sp_ssp')->nullable();
            $table->string('sp_raza')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ced_sp');
    }
};
