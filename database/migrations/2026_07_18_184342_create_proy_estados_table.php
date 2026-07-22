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
        Schema::create('proy_estado', function (Blueprint $table) {
            $table->id('predo_id');
            $table->foreignId('predo_proyid')->constrained('proy_proyectos','proy_id')->onDelete('cascade'); ###### ID del proyecto
            $table->enum('predo_act',['0','1','2'])->default('1');  ##### activo lógico inactivo
            $table->enum('predo_del',['0','1'])->default('0');  ##### borrado lógico inactivo
            $table->decimal('predo_edo',4,1)->default('0.0');  ##### estado del proyecto en número
            $table->text('predo_estado')->nullable();   ##### Estado en texto
            $table->longText('predo_comentario')->nullable();  ##### comentario del estado
            $table->date('predo_fecha')->nullable();  ##### fecha del estado
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proy_estado');
    }
};
