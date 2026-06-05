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
        Schema::create('lista', function (Blueprint $table) {
            $table->id('lst_id');
            $table->enum('lst_act',['0','1'])->default('1');  ##### borrado lógico inactivo
            $table->enum('lst_del',['0','1'])->default('0'); ##### borrado lógico
            $table->string('lst_cjarsiglas'); ##### Siglas del jardín al que pertenece
            $table->integer('lst_edo')->default(0); ##### Estado del ejemplar (0=planeado, 1=en proceso, 2=finalizado)
            $table->decimal('lst_orden', 10, 2)->nullable(); ##### Orden de aparición en la lista

            $table->string('lst_reino')->nullable(); ##### Nombre científico de la especie
            $table->string('lst_familia')->nullable(); ##### Nombre científico de la especie
            $table->string('lst_genero')->nullable(); ##### Nombre científico de la especie
            $table->string('lst_sp')->nullable(); ##### Nombre científico de la especie
            $table->string('lst_ssp')->nullable(); ##### Nombre científico de la especie
            $table->string('lst_scname')->nullable(); ##### Nombre científico de la especie
            $table->string('lst_var')->nullable(); ##### Nombre científico de la especie

            $table->string('lst_name')->nullable(); ##### Nombre común de la especie
            $table->string('lst_notas')->nullable(); ##### Notas sobre la especie
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lista');
    }
};
