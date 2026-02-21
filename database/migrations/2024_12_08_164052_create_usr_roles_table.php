<?php

use App\Models\User;
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
        // --------------- En producción
        if(!Schema::hasTable('usr_roles')){
            Schema::create('usr_roles', function (Blueprint $table) {
                $table->id('rol_id');
                $table->enum('rol_act',['0','1'])->default('1');  ##### Binario de inactividad
                $table->enum('rol_del',['0','1'])->default('0');  ##### Binario de borrado lógico
                $table->foreignId('rol_usrid')->constrained('users','id'); #### número id del usuario (de table users)

                $table->string('rol_cjarsiglas');
                // $table->foreign('rol_cjarsiglas')->references('cjar_siglas')->on('cat_jardines')->constrained('cat_jardines','cjar_siglas');

                $table->string('rol_crolrol')->default('usr');
                $table->foreign('rol_crolrol')->references('crol_rol')->on('cat_roles')->constrained('cat_roles','crol_rol');


                $table->string('rol_tipo1')->nullable();  ##### En caso de requerirse, descriptor del rol (x ej, con admin-jardin: "JebOax")
                $table->string('rol_tipo2')->nullable();  ##### En caso de requerirse, descriptor del rol (x ej, con admin-jardin: "animales")
                $table->string('rol_describe')->nullable()->default('Usuario de sistema');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // --------------- En producción. No borrar porque ya tiene datos de usuarios en producción.
        Schema::dropIfExists('usr_roles');
    }
};
