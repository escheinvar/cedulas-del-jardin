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
        Schema::create('autor_url', function (Blueprint $table) {
            $table->id('aurl_id');
            $table->enum('aurl_act',['0','1'])->default('1');  ##### borrado lógico inactivo
            $table->enum('aurl_del',['0','1'])->default('0'); ##### borrado lógico

            $table->integer('aurl_edo')->default('0');  #### Estado 0=creación(xAutor o Trad.), 1=edición(Xeditor) 2=revisión(xAutor o trad) 3=Autorizacin(x admin), 4=Publicada, 5=PublicadaConSolicitudDeEdición
            $table->enum('aurl_edit',['0','1'])->default('0'); ##### Estado de edición
            $table->integer('aurl_ciclo')->default('0');  #### Número de autorizaciones completas un ciclo= estado 0 a 4

            $table->foreignId('aurl_cautid')->constrained('cat_autores','caut_id');  ##### Id del catálogo de autores
            $table->string('aurl_cjarsiglas');   ##### Siglas del jardín al que pertenece la cédula
            $table->foreign('aurl_cjarsiglas')->references('cjar_siglas')->on('cat_jardines')->constrained('cat_jardines','cjar_siglas');
            $table->string('aurl_urltxt');       #### Nombre del autor(sin traducción) (compartido con las traducciones y único por jardín)
            $table->string('aurl_url');     ##### Nombre del autor+lengua
            // $table->foreign('aurl_url')->references('caut_nombreautor')->on('cat_autores')->constrained('cat_autores','caut_nombreautor');
            $table->string('aurl_key')->nullable();     ##### key: jardin + urltxt (sin traducción)NOTA: key con traducción es equivalente a aurl_id

            $table->string('aurl_lencode');      ##### Lengua de la cédula
            $table->foreign('aurl_lencode')->references('len_code')->on('lenguas')->constrained('lenguas','len_code');
            $table->integer('aurl_tradid');      ##### aurl_id de la cédula de la que proviene la traducción o 0 para original

            $table->string('aurl_titulo')->nullable();  ##### Título original de la cédula
            $table->string('aurl_tituloorig')->nullable(); ##### Título traducido de la cédula
            $table->longText('aurl_resumen')->nullable(); ##### Resumen de la cédula
            $table->longText('aurl_resumenorig')->nullable(); ##### Resumen traducido de la cédula
            $table->decimal('aurl_version',5 ,2)->default('1.0');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('autor_url');
    }
};
