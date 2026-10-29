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
        Schema::create('lista_nombresc', function (Blueprint $table) {
            $table->id('lstsc_id');
            $table->enum('lstsc_act',['0','1'])->default('1');  ##### borrado lógico inactivo
            $table->enum('lstsc_del',['0','1'])->default('0'); ##### borrado lógico
            $table->foreignId('lstsc_lstid')->constrained('lista','lst_id')->onDelete('cascade'); ##### Id de la especie en la lista

            $table->string('lstsc_reino')->nullable(); ##### Nombre científico de la especie
            $table->string('lstsc_familia')->nullable(); ##### Nombre científico de la especie
            $table->string('lstsc_genero')->nullable(); ##### Nombre científico de la especie
            $table->string('lstsc_sp')->nullable(); ##### Nombre científico de la especie
            $table->string('lstsc_ssp')->nullable(); ##### Nombre científico de la especie
            $table->string('lstsc_scname')->nullable(); ##### Nombre científico de la especie
            $table->string('lstsc_var')->nullable(); ##### Nombre científico de la especie

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lista_nombresc');
    }
};
