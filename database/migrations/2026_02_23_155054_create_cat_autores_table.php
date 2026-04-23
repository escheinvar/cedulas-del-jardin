<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cat_autores', function (Blueprint $table) {
            $table->id('caut_id');
            $table->enum('caut_act',['0','1'])->default('1');  ##### borrado lógico inactivo
            $table->enum('caut_del',['0','1'])->default('0'); ##### borrado lógico
            // $table->enum('caut_edit',['0','1'])->default('0'); ##### flag de edit (0=pñublico, 1=en-edición)

            // $table->string('caut_cjarsiglas');
            // $table->foreign('caut_cjarsiglas')->references('cjar_siglas')->on('cat_jardines')->constrained('cat_jardines','cjar_siglas');

            $table->string('caut_nombre');                ##### Nombre(s) del autor
            $table->string('caut_apellido1');             ##### Primer apellido(s) del autor
            $table->string('caut_apellido2')->nullable(); ##### Segundo apelldo(s) del autor
            $table->string('caut_nombreautor')->unique(); ##### Nombre de autor xej: Gámez-Tamariz N. ò Gámez N.
            $table->string('caut_url');                   ##### Url (nombreautorSinEspacios)
            $table->string('caut_correo')->nullable();    #### Correo electrńico
            $table->string('caut_institu')->nullable();   #### Institución
            $table->string('caut_comunidad')->nullable(); #### Nombre de la comunidad de origen
            // $table->string('caut_tel')->nullable();       #### Teléfono
            $table->integer('caut_usrid')->nullable();     #### En caso de haberlo, id de usuario
            // $table->string('caut_lenguas')->default('spa;'); ##### texto de array con lenguas separadas por punto y coma
            // $table->enum('caut_web',['0','1'])->default('0'); ##### flag de existencia de web
            $table->enum('caut_mailpublic',['0','1'])->default('0'); ##### flag de autorización para publicar datos
            $table->string('caut_orcid')->nullable();       #### Número identificador de autor académico (orcid)
            $table->string('caut_scopus')->nullable();      #### Número identificador de autor académico (scopus)
            $table->string('caut_isni')->nullable();        #### Número identificador de autor académico (International Standard Name Identifier)
            $table->string('caut_google')->nullable();        #### Dirección URL de autor de gogogle academico
            $table->string('caut_rgate')->nullable();        #### Url de research gate


            // $table->string('caut_otrosid')->nullable();       #### Array; nombre@valor; de números identificadores de autor académico

            // $table->string('caut_img')->nullable();      ##### Ruta al archivo de imagen del autor
            $table->timestamps();

            // $table->unique(['caut_cjarsiglas','caut_url']);
        });
        ##### Activa extensión para búsquedas sin acento
        DB::statement('CREATE EXTENSION IF NOT EXISTS unaccent');
        ##### usar: ->whereRaw("unaccent(name) ILIKE unaccent(?)", ['%'.$search.'%'])->get();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cat_autores');
    }
};
