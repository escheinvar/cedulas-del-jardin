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
        if(!Schema::hasTable('users')){
            Schema::create('users', function (Blueprint $table) {
                $table->id();
                $table->string('email')->unique();
                $table->enum('act',['0','1'])->default('1');
                $table->string('usrname')->unique();
                $table->string('nombre');
                $table->string('apellido');
                $table->date('nace')->nullable();  ## Año, mes y dia de nacimiento
                // $table->string('cinsid')->nullable(); ## Organización a la que pertenece ó número id de cat_instituciones
                $table->foreignId('cinsid')->constrained('cat_instituciones','cins_id');
                $table->string('avatar')->nullable()->default('/avatar/usr.png');

                $table->timestamp('email_verified_at')->nullable();
                $table->string('password');
                $table->rememberToken();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // --------------- En producción (cédulas: no borrar, pues tiene datos de usuarios en producción)
        // Schema::dropIfExists('users');
    }
};
