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
        if(!Schema::hasTable('sp_aporte_usrs')){
            Schema::create('sp_aporte_usrs', function (Blueprint $table) {
                $table->id('msg_id');
                $table->enum('msg_act',['0','1'])->default('1');
                $table->integer('msg_edo')->default('0'); ##0:enviado x usr 1:pausado x admin, 2:canceladox admin, 3:publico
                $table->integer('msg_cedid');   #### Idde cedula a la que pertenece la aportación
                $table->integer('msg_usr'); #### ID del usuario que envía la aportación
                $table->string('msg_usuario'); #### username de quien envía la aportación
                $table->string('msg_origen')->nullable(); #### dato ingresado por quien envía "soy originario de2.."
                $table->string('msg_edad')->nullable(); #### dato ingresado por quien envía "Edad"
                $table->longText('msg_mensaje')->nullable(); ##### Texto del mensaje
                $table->date('msg_date');

                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sp_aporte_usrs');
    }
};
