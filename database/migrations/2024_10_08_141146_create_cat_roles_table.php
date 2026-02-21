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
        if(!Schema::hasTable('cat_roles')){
            Schema::create('cat_roles', function (Blueprint $table) {
                $table->id('crol_id');
                $table->string('crol_mod')->default('base');     ### nombre del módulo al que pertenece el rol
                $table->string('crol_rol')->unique()->key();     ### nombre del rol
                $table->string('crol_gps')->nullable();         ### array de nombres de grupos a los que pertenece el rol
                $table->string('crol_describe')->nullable(); ### texto descriptivo modulo:rol
                $table->string('crol_notas')->nullable(); ### notas sobre el rol
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        ##### No borrar porque se utiliza en las tablas de usuario en producción.
        Schema::dropIfExists('cat_roles');
    }
};
