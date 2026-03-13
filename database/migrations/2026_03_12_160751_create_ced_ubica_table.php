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
        Schema::create('ced_ubica', function (Blueprint $table) {
            $table->id('ubi_id');
            $table->enum('ubi_act',['0','1'])->default('1');  ##### borrado lógico inactivo
            $table->enum('ubi_del',['0','1'])->default('0'); ##### borrado lógico
            $table->string('ubi_cjarsiglas');     #### Jardín al que pertenece
            $table->string('ubi_urlurl');     #### url de la cédula ej: huaje_huv

            $table->string('ubi_tipo')->nullable(); ##### Tipo de ubica.: localidad, región, área, poblado, zona
            $table->string('ubi_edo')->nullable();
            $table->string('ubi_mpio')->nullable();
            $table->string('ubi_localidad')->nullable();
            $table->string('ubi_paraje')->nullable();
            $table->string('ubi_ubicacion')->nullable(); ##### Texto final de ubiación (donde se hace la búsqueda concatenando todo)
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ced_ubica');
    }
};
