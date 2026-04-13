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
        Schema::create('ced_externos', function (Blueprint $table) {
            $table->id('ext_id');
            $table->enum('ext_act',['0','1'])->default('1');  ##### borrado lógico inactivo
            $table->enum('ext_del',['0','1'])->default('0'); ##### borrado lógico

            $table->string('ext_jardin');   ##### Jardín al que pertenece
            $table->string('ext_urltxt'); ###### url (sin traducción) a la que pertenece
            $table->foreignId('ext_redid')->constrained('cat_redes','red_id'); ###### Nombre de la fuente xej: facebook, inkscape,

            $table->string('ext_titulo')->nullable(); ###### Título del video
            $table->string('ext_autorname')->nullable(); ###### Nombre del autor xej:@FonsecaMx o @AmJarEtnobiologico
            $table->string('ext_autorurl')->nullable(); ###### Liga a perfil del autor http://...
            $table->string('ext_explica')->nullable(); ###### Texto de explicación del video
            $table->string('ext_url');     ###### Liga al video o fuente
            $table->string('ext_caratula')->nullable(); ###### Liga a archivo de imagen de portada
            $table->string('ext_fecha')->nullable(); ###### Fecha del documento
            $table->string('ext_ultverific')->nullable(); ###### Fecha de verificación.

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ced_externos');
    }
};
