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
        Schema::create('ced_catalogo', function (Blueprint $table) {
            $table->id('cat_id');
            $table->string('cat_tipo'); ###### Tipo que unifica valores
            $table->string('cat_valor'); ##### Valor del catálogo
            $table->string('cat_explica')->nullable(); ##### Explicación del valor
            $table->unique(['cat_tipo','cat_valor']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ced_catalogo');
    }
};
