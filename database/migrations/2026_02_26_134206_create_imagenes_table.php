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

            $table->string('img_cjarsiglas'); #### jardin al que pertenece el objeto cjar_siglas de tabla cat_jardines
            $table->string('img_urltxt')->nullable(); ##### en su caso, urltxt (sin lengua)
            $table->string('img_key')->nullable();   ##### en su caso key automático: url@jardin
            $table->integer('img_urlid')->nullable(); ##### en su caso, Id de la url de origen

            $table->string('img_cimgmodulo'); #### cimg_modulo de tabla cat_img. Indica la página o sección en la que aparece del objeto en una página
            $table->string('img_cimgtipo');  #### cimg_tipo de tabla cat_img. Indica la posición dentro de una página en donde aparece el objeto.
            // $table->string('img_urlurl')->nullable(); ##### en su caso, url (con lengua)
            // $table->string('img_lencode')->nullable(); ##### en su caso, lengua
            $table->enum('img_tipo',['img','aud','vid','you','htm','otro'])->nullable(); ##### tipo de objeto: IMGen, AUDio, VIDeo, liga Web, YOUtube

            $table->string('img_file')->nullable(); ##### archivo del objeto (ubicado en /public/img)
            $table->longText('img_youtube')->nullable(); ##### Cve de url youtube: ej:K3LicGankn0 (luego de v= y antes de &)en https://www.youtube.com/watch?v=K3LicGankn0&t=27s
            $table->longText('img_html')->nullable(); ##### Código html para embeber objeto externo (x ej. youtube)

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
