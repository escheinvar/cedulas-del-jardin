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
        if(!Schema::hasTable('cat_entidades_inegi')){
            Schema::create('cat_entidades_inegi', function (Blueprint $table) {
                $table->id('cedo_id');
                $table->string('cedo_nombre');
                $table->string('cedo_abrevia');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cat_entidades_inegi');
    }
};
