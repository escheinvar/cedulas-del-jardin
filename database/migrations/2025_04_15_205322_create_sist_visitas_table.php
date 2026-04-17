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
        Schema::create('sist_visitas', function (Blueprint $table) {
            $table->id('vis_id');
            $table->enum('vis_entrada',['1','0'])->default('0'); ##### Define la url en la que se genera el token (página desde donde inicia el usuario)

            $table->string('vis_jardin')->nullable();   ##### Siglas del jardín al que pertenece la url
            $table->string('vis_modulo')->nullable();   ##### Módulo al que pertenece la url (cedula, autor, jardin, etc...)
            $table->string('vis_urltxt')-> nullable(); ##### Dirección url (sin lengua) de la página
            $table->string('vis_lengua')->nullable();   ##### Código de la lengua
            $table->string('vis_url')->nullable();      ##### Dirección url que está siendo visitada
            $table->string('vis_flag')->nullable();  ##### Texto de identificación 1
            // $table->string('vis_identi2')->nullable();  ##### Texto de identificación 1

            // $table->string('vis_url2')->nullable();
            // $table->string('vis_url3')->nullable();

            $table->string('vis_ip')->nullable();       ##### Ip desde la que se visita
            $table->string('vis_locale')->nullable();   ##### Locale del que visita
            // $table->string('vis_locale2')->nullable();
            $table->string('vis_pais')->nullable();     ##### País desde el que se visita
            $table->string('vis_region')->nullable();#### Región desde la que se visita
            $table->string('vis_ciudad')->nullable();   ##### Ciudad desde la que se visita
            $table->decimal('vis_x',10,7)->nullable();  ##### Coordenadas longitud x desde donde se visita
            $table->decimal('vis_y',10,7)->nullable();  ##### Coordenadas latitud y desde donde se visita

            $table->string('vis_usr')->nullable();      ##### Si visitante está logeado, el número de Usr
            $table->string('vis_rol')->nullable();      ##### Si visitante está logeado, el número rol del Usr
            $table->string('vis_tocken')->nullable();   ##### Número de token que identifica la visita

            $table->integer('vis_anio');
            $table->integer('vis_mes');
            $table->integer('vis_dia');
            $table->date('vis_fecha');
            $table->time('vis_hora');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sist_visitas');
    }
};
