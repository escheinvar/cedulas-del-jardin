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
        Schema::create('ced_usos', function (Blueprint $table) {
            $table->id('uso_id');
            $table->enum('uso_act',['0','1'])->default('1');  ##### borrado lógico inactivo
            $table->enum('uso_del',['0','1'])->default('0'); ##### borrado lógico
            $table->foreignId('uso_spid')->constrained('ced_sp','sp_id');       #### Id de la especie a la que se vincula el uso
            $table->string('uso_spname')->nullable(); ##### nombre de especie según tabla ced_sp
            $table->string('uso_cjarsiglas');     #### Jardín al que pertenece
            $table->string('uso_urltxt');     #### urltxt de la cédula ej: huaje (sin traducción)
            $table->string('uso_key'); ##### key: jardin + urltxt (sin traducción)NOTA: key con traducción es equivalente a url_id

            $table->string('uso_categoria')->nullable();  ##### cuso_catego del catálogo cat_uso
            $table->string('uso_uso')->nullable(); ##### cuso_uso del catálogo cat_uso
            $table->longText('uso_partes')->nullable(); #### array; de cat_valor dado cat_tipo=parteplanta de ced_catalogo
            $table->longText('uso_describe')->nullable(); #### Descripción
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ced_usos');
    }
};
