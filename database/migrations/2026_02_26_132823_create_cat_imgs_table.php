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
        Schema::create('cat_img', function (Blueprint $table) {
            $table->id('cimg_id');
            $table->string('cimg_modulo');
            $table->string('cimg_tipo');
            $table->string('cimg_explica')->nullable();
            $table->primary(['cimg_modulo','cimg_tipo'])->key();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cat_img');
    }
};
