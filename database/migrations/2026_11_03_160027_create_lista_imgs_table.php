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
        Schema::create('lista_img', function (Blueprint $table) {
            $table->id('lstimg_id');
            $table->enum('lstimg_act',['0','1'])->default('1');  ##### borrado lógico inactivo
            $table->enum('lstimg_del',['0','1'])->default('0'); ##### borrado lógico
            $table->foreignId('lstimg_lstid')->constrained('lista','lst_id')->onDelete('cascade'); ##### Id de la especie en la lista

            $table->decimal('lstimg_orden',4,1)->default('1.0');
            $table->string('lstimg_img');

            $table->string('lstimg_titulo')->nullable();
            $table->string('lstimg_autor')->nullable();
            $table->string('lstimg_explica')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lista_img');
    }
};
