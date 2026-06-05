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
        Schema::create('jue_memoria', function (Blueprint $table) {
            $table->id('mem_id');
            $table->foreignId('mem_jueid')->constrained('juegos','jue_id')->onDelete('cascade');
            $table->enum('mem_act',['0','1'])->default('1');  ##### borrado lógico inactivo
            $table->enum('mem_del',['0','1'])->default('0'); ##### borrado lógico
            $table->string('mem_name');
            $table->string('mem_par');
            $table->string('mem_txt')->nullable();
            $table->string('mem_img')->nullable();
            $table->string('mem_aud')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jue_memoria');
    }
};
