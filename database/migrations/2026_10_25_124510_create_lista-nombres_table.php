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
        Schema::create('lista_nombres', function (Blueprint $table) {
            $table->id('lstn_id');
            $table->enum('lstn_act',['0','1'])->default('1');  ##### borrado lógico inactivo
            $table->enum('lstn_del',['0','1'])->default('0'); ##### borrado lógico
            $table->foreignId('lstn_lstid')->constrained('lista','lst_id')->onDelete('cascade'); ##### Id de la especie en la lista
            $table->string('lstn_name'); ##### Nombre común de la especie
            $table->string('lstn_audio')->nullable(); ##### Nombre del archivo de audio del nombre común
            $table->string('lstn_lengua')->nullable(); ##### Lengua del nombre común
            $table->string('lstn_lencode')->nullable(); ##### Còdigo de Lengua del nombre común
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lista_nombres');
    }
};
