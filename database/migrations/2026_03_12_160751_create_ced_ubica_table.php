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
            $table->foreignId('ubi_urlid')->constrained('cedula_url','url_id'); ##### Id de la cédula
            $table->string('ubi_cjarsiglas');     #### Jardín al que pertenece
            $table->string('ubi_urltxt');     #### urltxt de la cédula ej: huaje (sin traducción)
            $table->string('ubi_urlurl');     #### url de la cédula ej: huaje_maa (con traducción)

            // $table->string('ubi_tipo')->nullable(); ##### Tipo de ubica.: localidad, región, área, poblado, zona
            $table->string('ubi_edo')->nullable(); #### Estado de la república
            $table->string('ubi_mpio')->nullable(); ##### Mpio en el que está
            $table->string('ubi_localidad')->nullable(); ##### Nombre de la localidad
            $table->string('ubi_paraje')->nullable();   ##### Nombre del paraje
            $table->decimal('ubi_x',12,8)->nullable(); ##### coords. x
            $table->decimal('ubi_y',12,8)->nullable(); ##### coords. y
            $table->string('ubi_ubicacion')->nullable(); ##### Texto final de ubiación (donde se hace la búsqueda concatenando todo)
            $table->string('ubi_ubicacion_tr')->nullable(); ##### Texto final de ubiación (donde se hace la búsqueda concatenando todo)
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
