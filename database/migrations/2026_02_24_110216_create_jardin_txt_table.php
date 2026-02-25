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
        if(!Schema::hasTable('jardin_txt')){
            Schema::create('jardin_txt', function (Blueprint $table) {
                $table->id('jar_id');

                $table->foreignId('jar_urljid')->constrained('jardin_url','urlj_id'); #### ID de la url

                $table->string('jar_urljurl');  ##### Texto de la url
                // $table->foreign('jar_urljurl')->references('urlj_url')->on('jardin_url')->constrained('jardin_url','urlj_url');

                $table->string('jar_cjarsiglas'); #####  siglas del jardín al que pertenece
                $table->foreign('jar_cjarsiglas')->references('cjar_siglas')->on('cat_jardines')->constrained('cat_jardines','cjar_siglas');

                $table->enum('jar_act',['0','1'])->default('1');  ##### borrado lógico inactivo
                $table->enum('jar_del',['0','1'])->default('0'); ##### borrado lógico

                $table->integer('jar_orden'); #### Número de orden del párrafo (dentro de cada url)
                $table->longText('jar_txt')->nullable(); ##### Código html del texto
                $table->string('jar_arch1')->nullable();
                $table->string('jar_arch2')->nullable();
                $table->string('jar_arch3')->nullable();
                $table->string('jar_arch4')->nullable();
                $table->string('jar_arch5')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jardin_txt');
    }
};
