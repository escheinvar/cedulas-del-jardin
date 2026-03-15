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
        Schema::create('imagenes', function (Blueprint $table) {
            $table->id('img_id');
            $table->enum('img_act',['0','1'])->default('1');  ##### borrado lógico inactivo
            $table->enum('img_del',['0','1'])->default('0'); ##### borrado lógico

            $table->string('img_cimgmodulo'); #### cimg_modulo de tabla cat_img
            $table->string('img_cimgtipo');  #### cimg_tipo de tabla cat_img
            $table->string('img_cjarsiglas'); #### cjar_siglas de tabla cat_jardines
            $table->string('img_urlurl')->nullable(); ##### en su caso, url
            $table->string('img_lencode')->nullable(); ##### en su caso, lengua
            $table->string('img_file')->nullable(); ##### archivo del objeto
            $table->longText('img_url')->nullable(); ##### Código html para embeber objeto externo o dirección url de liga
            $table->longText('img_urltxt')->nullable(); ##### Código html para embeber objeto externo o dirección url de liga
            $table->enum('img_tipo',['img','aud','tau','vid','otro'])->nullable(); ##### tipo de objeto
            $table->string('img_size')->nullable(); #### Tamaño en MB del objeto
            $table->string('img_resolu')->nullable(); #### Resolución en px X,Y
            $table->string('img_titulo')->nullable(); ##### tiulo de la imágen
            $table->enum('img_tituloact',['0','1'])->default('0'); ##### flag de título visible
            $table->string('img_pie')->nullable(); ##### pie de figura
            $table->string('img_explica')->nullable(); ##### explicación de la figura
            $table->string('img_autor')->nullable(); ##### Nombre del autor
            $table->date('img_fecha')->nullable(); ##### Fecha del objeto
            $table->string('img_ubica')->nullable(); ##### notas de ubiación
            $table->decimal('img_lonx',12,8)->nullable(); ##### longitud
            $table->decimal('img_laty',12,8)->nullable(); ##### latitud
            $table->integer('img_usrid')->nullable(); ##### Id del usuario que registra

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('imagenes');
    }
};
