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
        if(!Schema::hasTable('cat_municipios_inegi')){
            Schema::create('cat_municipios_inegi', function (Blueprint $table) {
                $table->id('cmun_id');
                #$table->foreignId('cmun_cedoid')->constrained('cat_entidades_inegi','cedo_id');  ##### ID de tabla pl_plantas
                $table->integer('cmun_cedoid');
                $table->string('cmun_edoname');
                $table->integer('cmun_mpioid');
                $table->string('cmun_mpioname');
                $table->integer('cmun_cabeceraid');
                $table->string('cmun_cabeceraname');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No borrar, porque el archivo de municipios se carga desde archivo.
        Schema::dropIfExists('cat_municipios_inegi');
    }
};
