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
        if(!Schema::hasTable('sist_buzon_mensajes')){
            Schema::create('sist_buzon_mensajes', function (Blueprint $table) {
                $table->id('buz_id');
                $table->enum('buz_act',['0','1'])->default('1');  ##### borrado lógico
                $table->enum('buz_leido',['0','1'])->default('0'); ##### flag de mensaje leído
                $table->string('buz_modulo');   ##### Módulo al que pertenece el mensaje (cédulas, plantas, sistema, usuarios)

                $table->integer('buz_usr_origen');  #### Número id del usuario que genera el mensaje
                $table->integer('buz_destino_usr')->nullable(); #####
                $table->string('buz_destino_rol')->nullable();
                $table->longText('buz_notas')->nullable();
                $table->string('buz_asunto');
                $table->string('buz_mensaje');
                $table->dateTime('buz_date_origen');
                $table->dateTime('buz_date_leido')->nullable();
                $table->dateTime('buz_date_borrado')->nullable();

                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // --------------- En producción, no borrar porque tiene mensajes en producción
        Schema::dropIfExists('sist_buzon_mensajes');
    }
};
