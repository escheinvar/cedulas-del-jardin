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
        // --------------- En producción
        if(!Schema::hasTable('www_eventos')){
            Schema::create('www_eventos', function (Blueprint $table) {
                $table->id('wwevs_id');
                $table->enum('wwevs_act',['0','1'])->default('1');  ##### borrado lógico
                $table->string('wwevs_titulo');                 ##### Título del evento
                $table->string('wwevs_descrip')->nullable();    ##### Breve descripción del evento
                $table->string('wwevs_descrip2')->nullable();    ##### Breve descripción del evento
                $table->string('wwevs_label')->nullable();      ##### Etiquetas [Recorrido, Presentación, Cultural, Comunicado, Taller] de tipo de evento (separados por coma) Ej: Recorrido, Conferencia, Taller, Comunicado
                $table->string('wwevs_lugar')->nullable();      ##### Lugar en el que se realiza el evento (ej: Jardín Etnobotánico de Oaxaca)
                $table->date('wwevs_dateini');                  ##### Fecha de inicio del evento
                $table->date('wwevs_datefin');      ##### Fecha de finalización del evento
                $table->time('wwevs_timeini', precision: 0);    ##### Hora de inicio del evento
                $table->time('wwevs_timefin', precision: 0)->nullable();##### Hora de finalización del evento
                $table->string('wwevs_costo')->nullable();      ##### Texto del costo (ej: Actividad gratuita, Costo: $50 por persona)
                $table->string('wwevs_img')->default('/imagenes/eventos/evento.png');

                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // --------------- En producción. No borrar porque hay eventos en producción.
        Schema::dropIfExists('www_eventos');
    }
};
