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
        Schema::create('cat_usos', function (Blueprint $table) {
            $table->id('cuso_id');
            $table->string('cuso_catego');
            // $table->string('cuso_parte');
            $table->longText('cuso_uso');
            $table->longText('cuso_describe')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cat_usos');
    }
};
