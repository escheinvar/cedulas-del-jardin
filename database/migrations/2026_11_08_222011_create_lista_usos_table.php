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
        Schema::create('lista_usos', function (Blueprint $table) {
            $table->id('lsuso_id');
            $table->enum('lsuso_act',['0','1'])->default('1');  ##### borrado lógico inactivo
            $table->enum('lsuso_del',['0','1'])->default('0'); ##### borrado lógico
            $table->foreignId('lsuso_lstid')->constrained('lista','lst_id')->onDelete('cascade'); ##### Id de la especie en la lista

            $table->string('lsuso_catego');  #### categoria de uso según catálogo
            $table->longText('lsuso_uso');  ##### uso según catálogo
            $table->longText('lsuso_describe')->nullable(); ##### texto descriptor

            $table->longText('lsuso_parte')->nullable(); ##### array de partes separadas con ;
            $table->longText('lsuso_nota')->nullable(); ### notas adicionales

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lista_usos');
    }
};
