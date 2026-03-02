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
        if(!Schema::hasTable('sp_cedulas')){
            Schema::create('sp_cedulas', function (Blueprint $table) {
                $table->id('txt_id');

                $table->foreignId('txt_cedid')->constrained('sp_urlcedula','ced_id'); ##### texto de la url
                $table->enum('txt_act',['0','1'])->default('1'); ##### Borrado lógico
                $table->enum('txt_titulo',['0','1'])->default('0'); ##### Indica si es título (h4) ò solo es código
                $table->decimal('txt_order',6,2)->default('0.0');  ##### Número de orden del párrafo
                $table->longText('txt_codigo')->nullable(); ##### Código html del párrafo
                $table->string('txt_autor')->nullable();     ##### id del autor del párrafo
                $table->string('txt_version')->nullable()->default('0.01');   ##### Versión del párrafo

                $table->string('txt_audio')->nullable();    ##### nombre del archivo de audio
                $table->string('txt_video')->nullable(); ### video asociada al párrafo
                $table->string('txt_img1')->nullable();  ### imagen asociada al párrafo
                $table->string('txt_img2')->nullable();  ### imagen asociada al párrafo
                $table->string('txt_img3')->nullable();  ### imagen asociada al párrafo
                $table->foreignId('txt_resp')->constrained('users','id'); ##### Id del responsable de subir a BD

                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // --------------- En producción. No borrar porque hay cédulas en producción
        Schema::dropIfExists('sp_cedulas');

    }
};
