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
        if(!Schema::hasTable('cat_instituciones')){
            Schema::create('cat_instituciones', function (Blueprint $table) {
                $table->id('cins_id');
                $table->string('cins_institucion');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        ##### No se puede tirar porque está asociado a tabla en producción (cédulas) que no se puede borrar
        // Schema::dropIfExists('cat_instituciones');
    }
};
