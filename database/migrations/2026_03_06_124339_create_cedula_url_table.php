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
        Schema::create('cedula_url', function (Blueprint $table) {
            $table->id('url_id');
            $table->enum('url_act',['0','1'])->default('1');  ##### borrado lógico inactivo
            $table->enum('url_del',['0','1'])->default('0'); ##### borrado lógico

            $table->integer('url_edo')->default('0');  #### Estado 0=creación(xAutor o Trad.), 1=edición(Xeditor) 2=revisión(xAutor o trad) 3=Autorizacin(x admin), 4=Publicada, 5=PublicadaConSolicitudDeEdición
            $table->enum('url_edit',['0','1'])->default('0'); ##### Estado de edición
            $table->integer('url_ciclo')->default('0');  #### Número de autorizaciones completas un ciclo= estado 0 a 4
            $table->string('url_ccedtipo');     #### Tipo de cédula que se construye
            $table->foreign('url_ccedtipo')->references('cced_tipo')->on('cat_tipocedulas')->constrained('cat_tipocedulas','cced_tipo');

            $table->string('url_cjarsiglas');   ##### Siglas del jardín al que pertenece la cédula
            $table->foreign('url_cjarsiglas')->references('cjar_siglas')->on('cat_jardines')->constrained('cat_jardines','cjar_siglas');
            $table->string('url_urltxt');       #### Nombre url de la cédula (compartido con las traducciones y único por jardín)
            $table->string('url_url');          ##### Código url (url_urltxt+_+url_lencode)
            $table->string('url_key'); ##### key: jardin + urltxt (sin traducción)NOTA: key con traducción es equivalente a url_id
            $table->string('url_lencode');      ##### Lengua de la cédula
            $table->foreign('url_lencode')->references('len_code')->on('lenguas')->constrained('lenguas','len_code');
            $table->integer('url_tradid');      ##### url_id de la cédula de la que proviene la traducción o 0 para original

            $table->string('url_titulo')->nullable();  ##### Título original de la cédula
            $table->string('url_tituloorig')->nullable(); ##### Título traducido de la cédula
            $table->longText('url_resumen')->nullable(); ##### Resumen de la cédula
            $table->longText('url_resumenorig')->nullable(); ##### Resumen traducido de la cédula
            $table->string('url_cita')->nullable(); ##### Cita de la cédula
            $table->string('url_anio')->nullable(); ##### Año de la cédula
            // $table->integer('url_editor')->nullable(); ##### Id_usr del editor asignado
            $table->decimal('url_version',5 ,2)->default('1.0');
            $table->string('url_doi')->nullable();

            $table->timestamps();
            $table->unique(['url_cjarsiglas','url_url']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cedula_url');
    }
};
