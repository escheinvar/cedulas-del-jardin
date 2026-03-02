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
        Schema::create('historial', function (Blueprint $table) {
            $table->id('log_id');
            $table->string('log_log'); ##### Explicación del evento
            $table->string('log_tabla')->nullable();  ##### Tabla o módulo afectado con el evento
            $table->string('log_tablaid')->nullable(); #### en caso de haberlo, ID de la tabla a la que corresponde.

            $table->integer('log_usrid');  ##### Id del usuario responsable del evento
            $table->date('log_fecha')->format('Y-m-d');
            $table->time('log_Hora');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historial');
    }
};
