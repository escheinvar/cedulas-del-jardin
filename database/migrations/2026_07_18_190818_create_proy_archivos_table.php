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
        Schema::create('proy_archivos', function (Blueprint $table) {
            $table->id('prmat_id');
            $table->foreignId('prmat_proyid')->constrained('proy_proyectos','proy_id')->onDelete('cascade'); ###### ID del proyecto
            $table->foreignId('prmat_predoid')->constrained('proy_estado','predo_id')->onDelete('cascade'); ###### ID del estado del proyecto
            $table->enum('prmat_del',['0','1'])->default('0');  ##### borrado lógico inactivo
            $table->string('prmat_archivo');  #####3 Nombre del archivo en la base de datos
            $table->string('prmat_nombrearch'); ##### Nombre original dado por el usuario
            $table->string('prmat_tipo'); #### Tipo de archivo (texto, imagen, video, audio)
            $table->foreignId('prmat_usr')->constrained('users','id')->onDelete('cascade'); ###### ID del autor
            $table->longText('prmat_comentario')->nullable();  ##### comentario del archivo
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proy_archivos');
    }
};
