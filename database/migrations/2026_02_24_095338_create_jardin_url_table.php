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
        Schema::create('jardin_url', function (Blueprint $table) {
            $table->id('urlj_id');

            $table->string('urlj_cjarsiglas'); #####  siglas del jardín al que pertenece
            $table->foreign('urlj_cjarsiglas')->references('cjar_siglas')->on('cat_jardines')->constrained('cat_jardines','cjar_siglas');

            $table->string('urlj_url'); ##### Nombre de url

            $table->enum('urlj_act',['0','1'])->default('1');  ##### borrado lógico inactivo
            $table->enum('urlj_del',['0','1'])->default('0'); ##### borrado lógico

            $table->integer('urlj_edit')->default('0');  #### Flag de estado de edición (1) o no edición (0)

            $table->string('urlj_titulo')->nullable(); ##### Texto que va en head metadato title
            $table->string('urlj_descrip')->nullable(); ##### Texto que va en head meta-description
            $table->string('urlj_bannerimg')->nullable(); ##### Ruta a archivo de banner en ruta: /public/jardines/
            $table->string('urlj_bannertitle')->nullable(); ##### Texto de título que aparece en banner

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jardin_url');
    }
};
