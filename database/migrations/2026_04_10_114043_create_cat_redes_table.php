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
        Schema::create('cat_redes', function (Blueprint $table) {
            $table->id('red_id');
            $table->string('red_name')->unique(); ##### Nombre de la red
            $table->string('red_url')->nullable(); ##### Dirección base de la red
            $table->string('red_icon')->nullable(); ##### código html del ícono
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cat_redes');
    }
};
