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
        Schema::create('proy_proyectos', function (Blueprint $table) {
            $table->id('proy_id');
            $table->string('proy_titulo');
            $table->string('proy_jardin');
            $table->enum('proy_act',['0','1'])->default('1');  ##### Archivado de proyecto
            $table->enum('proy_del',['0','1'])->default('0');  ##### borrado lógico inactivo
            $table->foreignId('proy_autor1')->nullable()->constrained('users','id')->onDelete('cascade'); ###### ID del autor
            $table->foreignId('proy_autor2')->nullable()->constrained('users','id')->onDelete('cascade'); ###### ID del autor
            $table->foreignId('proy_autor3')->nullable()->constrained('users','id')->onDelete('cascade'); ###### ID del autor
            $table->foreignId('proy_admin')->nullable()->constrained('users','id')->onDelete('cascade'); ###### ID del autor
            $table->foreignId('proy_editor')->nullable()->constrained('users','id')->onDelete('cascade'); ###### ID del autor
            $table->date('proy_fecha')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proy_proyectos');
    }
};
