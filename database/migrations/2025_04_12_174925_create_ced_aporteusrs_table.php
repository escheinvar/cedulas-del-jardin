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
        if(!Schema::hasTable('ced_aporteusrs')){
            Schema::create('ced_aporteusrs', function (Blueprint $table) {
                $table->id('msg_id');
                $table->enum('msg_act',['0','1'])->default('1');
                $table->enum('msg_del',['0','1'])->default('0');

                $table->integer('msg_edo')->default('0'); ##0:enviado x usr 1:pausado x admin, 2:canceladox admin, 3:publico
                $table->string('msg_cjarsiglas');  ##### Jardin
                $table->integer('msg_urlid');   #### Idde cedula a la que pertenece la aportación
                $table->string('msg_url'); ##### url de página
                $table->string('msg_urltxt'); ##### url de página (sin lengua)
                $table->string('msg_key')->nullable(); #### jardin@url

                $table->string('msg_nombre')->nullable(); ##### Nombre real del usuario
                $table->string('msg_usuario')->nullable(); #### Nombre público del usuario
                $table->string('msg_estado')->nullable(); #### dato ingresado por quien envía "soy originario de2.."
                $table->string('msg_mpio')->nullable(); #### dato ingresado por quien envía "soy originario de2.."
                $table->string('msg_comunidad')->nullable(); #### dato ingresado por quien envía "soy originario de2.."
                $table->string('msg_lengua')->nullable(); #### dato ingresado por quien envía "soy originario de2.."
                $table->string('msg_edad')->nullable(); #### dato ingresado por quien envía "Edad"
                $table->string('msg_correo')->nullable(); ##### correo del usuario
                $table->string('msg_tel')->nullable(); ##### teléfono
                $table->longText('msg_mensaje')->nullable(); ##### Texto del mensaje
                $table->longText('msg_mensajeoriginal')->nullable();
                $table->integer('msg_usr'); #### ID del usuario que envía la aportación
                $table->date('msg_date');
                $table->string('msg_nota')->nullable();  ##### Notas de razón de suspensión o cancelación

                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ced_aporteusrs');
    }
};
