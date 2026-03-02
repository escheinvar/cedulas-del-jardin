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
        if(!Schema::hasTable('sp_urlcedula_versiones')){
            Schema::create('sp_urlcedula_versiones', function (Blueprint $table) {
                $table->id('cedv_id');
                $table->integer('cedv_cedid');
                $table->decimal('cedv_cedversion',5,2); ##### Versión de la cédula
                $table->integer('cedv_usr');
                $table->longText('cedv_pdf');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sp_urlcedula_versiones');
    }
};
