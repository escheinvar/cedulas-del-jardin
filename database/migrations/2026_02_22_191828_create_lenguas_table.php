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


     if(!Schema::hasTable('lenguas')){
            Schema::create('lenguas', function (Blueprint $table) {
                $table->id('len_id');
                $table->string('len_code')->unique();  ##### Código usado por el sistema para identificar la lengua
                $table->string('len_lengua'); ##### Nombre de la lengua en español
                $table->string('len_variante')->nullable(); #####
                $table->string('len_altnames')->nullable(); ##### Nombres alternativos
                $table->string('len_autonimias')->nullable(); ##### Nombre,de la lengua según la propia lengua
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lenguas');
    }
};
