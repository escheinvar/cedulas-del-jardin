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
        Schema::create('ced_usos', function (Blueprint $table) {
            $table->id('uso_id');
            $table->enum('uso_act',['0','1'])->default('1');  ##### borrado lógico inactivo
            $table->enum('uso_del',['0','1'])->default('0'); ##### borrado lógico
            $table->string('uso_cjarsiglas');     #### Jardín al que pertenece
            $table->string('uso_urlurl');     #### url de la cédula ej: huaje_huv

            $table->string('uso_categoria')->nullable();
            $table->string('uso_parte')->nullable();
            $table->string('uso_uso')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ced_usos');
    }
};
