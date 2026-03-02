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
        Schema::create('sist_visitas', function (Blueprint $table) {
            $table->id('vis_id');
            $table->enum('vis_unique',['1','0'])->default('0');
            $table->string('vis_ip')->nullable()    ;
            $table->string('vis_url')->nullable();
            $table->string('vis_url2')->nullable();
            $table->string('vis_url3')->nullable();
            $table->string('vis_locale')->nullable();
            $table->string('vis_locale2')->nullable();
            $table->string('vis_tocken')->nullable();
            $table->string('vis_pais')->nullable();
            $table->string('vis_regionname')->nullable();
            $table->string('vis_ciudad')->nullable();
            $table->decimal('vis_x',10,7)->nullable();
            $table->decimal('vis_y',10,7)->nullable();

            $table->string('vis_usr')->nullable();
            $table->string('vis_rol')->nullable();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sist_visitas');
    }
};
