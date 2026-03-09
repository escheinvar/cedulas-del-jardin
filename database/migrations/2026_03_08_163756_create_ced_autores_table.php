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
        Schema::create('ced_autores', function (Blueprint $table) {
            $table->id('aut_id');
            $table->foreignId('aut_cautid')->constrained('cat_autores','caut_id'); ##### Id del autor
            $table->foreignId('aut_urlid')->constrained('cedula_url','url_id'); ##### Id de la cédula
            $table->enum('aut_act',['0','1'])->default('1');  ##### borrado lógico inactivo
            $table->enum('aut_del',['0','1'])->default('0'); ##### borrado lógico
            $table->decimal('aut_orden',4,2)->default('1.0'); ##### orden del autor
            $table->enum('aut_corresponding',['0','1'])->default('0'); ##### Indica si es(1) o no es(0) corresponding autor
            $table->string('aut_correo')->nullable(); ##### Correo electrónico del autor
            $table->string('aut_institucion')->nullable(); ##### Institución a la que pertenece el autor
            $table->string('aut_tipo')->default('Autor'); #### tipo: Autor, Traductor, Editor
            $table->integer('aut_usrid')->nullable(); #### En caso de haberlo, id de usuario

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ced_autores');
    }
};
