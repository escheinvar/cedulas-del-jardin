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
        // --------------- En producción
        if(!Schema::hasTable('sp_fotos')){
            Schema::create('sp_fotos', function (Blueprint $table) {
                $table->id('imgsp_id');

                $table->string('imgsp_urlurl'); ##### URL de la especie a la que pertenece la imagen
                $table->foreign('imgsp_urlurl')->references('url_url')->on('sp_url')->onDelete('cascade')->constrained('sp_url','url_url');  ##### ID de tabla pl_plantas

                $table->string('imgsp_cjarsiglas'); ##### URL de la especie a la que pertenece la imagen
                $table->foreign('imgsp_cjarsiglas')->references('cjar_siglas')->on('cat_jardines')->onDelete('cascade')->constrained('cat_jardines','cjar_siglas');  ##### ID de tabla pl_plantas

                $table->enum('imgsp_act',['0','1'])->default('1'); ##### Borrado lógico
                $table->string('imgsp_file')->nullable();  ##### Texto con la ubicación del archivo de imágen con resolucion normal
                $table->string('imgsp_filelow')->nullable();  ##### Texto con la ubicación del archivo de imágen con resolución baja

                $table->string('imgsp_cimgname');   ##### texto de tabla catálogo de imagenes con nombre de label (posición de la foto)
                $table->foreign('imgsp_cimgname')->references('cimg_name')->on('cat_fotoplantaslabel')->onDelete('cascade')->constrained('cimg_name','cat_fotoplantaslabel');

                $table->string('imgsp_autor')->nullable(); ##### Texto con el nombre del autor de la imagen
                $table->string('imgsp_titulo')->nullable(); ##### Texto con el nombre del tìtulo de la imagen
                $table->string('imgsp_pie')->nullable(); ##### Texto de pie de figura de la imágen
                $table->date('imgsp_date')->nullable(); ##### Fecha de la imagen
                $table->string('imgsp_descrip')->nullable(); ##### Breve texto con descripción de la imagen
                $table->string('imgsp_metadata')->nullable(); ##### Array con punto y coma de metadatos de la foto.

                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // --------------- En producción. No borrar porque tiene imágenes en producción.
        // Schema::dropIfExists('sp_fotos');
    }
};
