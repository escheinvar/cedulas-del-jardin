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
        Schema::create('ced_alias', function (Blueprint $table) {
            $table->id('ali_id');
            $table->enum('ali_act',['0','1'])->default('1');  ##### borrado lógico inactivo
            $table->enum('ali_del',['0','1'])->default('0'); ##### borrado lógico
            $table->string('ali_cjarsiglas');     #### Jardín al que pertenece
            $table->string('ali_urlurl');     #### url de la cédula ej: huaje_huv

            $table->string('ali_calitipo'); ##### tipo de alias según catálogo
            $table->string('ali_txt');  ##### texto del alias
            $table->string('ali_lengua')->default('spa'); ##### código de lengua
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ced_alias');
    }
};
