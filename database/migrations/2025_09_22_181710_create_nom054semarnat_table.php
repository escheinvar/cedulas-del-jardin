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
        #####  DOF 14/11/2019.
        #####  MODIFICACIÓN del Anexo Normativo III, Lista de especies en riesgo de la Norma Oficial Mexicana NOM-059-SEMARNAT-2010, Protección ambiental-Especies nativas de México de flora y fauna silvestres-Categorías de riesgo y especificaciones para su inclusión, exclusión o cambio-Lista de especies en riesgo, publicada el 30 de diciembre de 2010.
        Schema::create('nom054semarnat', function (Blueprint $table) {
            $table->id('nom_id');
            $table->string('nom_grupo');
            $table->string('nom_subgrupo');
            $table->string('nom_familia');
            $table->string('nom_genero');
            $table->string('nom_especie');
            $table->string('nom_catinfrasp')->nullable();
            $table->string('nom_infrasp')->nullable();
            $table->string('nom_autor')->nullable();
            $table->mediumText('nom_sinonimia')->nullable();
            $table->mediumText('nom_comunname')->nullable();
            $table->string('nom_distri')->nullable();
            $table->string('nom_cat');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nom054semarnat');
    }
};
