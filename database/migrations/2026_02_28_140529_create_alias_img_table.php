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
        Schema::create('alias_img', function (Blueprint $table) {
            $table->id('aimg_id');
            $table->foreignId('aimg_imgid')->constrained('imagenes','img_id'); ##### Id de la imagen
            $table->enum('aimg_act',['0','1'])->default('1');  ##### borrado lógico inactivo
            $table->enum('aimg_del',['0','1'])->default('0'); ##### borrado lógico
            $table->string('aimg_txt');  ##### Texto del alias
            $table->string('aimg_lencode')->default('spa');  ##### Lengua en la que está el alias
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alias_img');
    }
};
