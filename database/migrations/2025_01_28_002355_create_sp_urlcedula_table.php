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
        if(!Schema::hasTable('sp_urlcedula')){
            Schema::create('sp_urlcedula', function (Blueprint $table) {
                $table->id('ced_id');
                $table->enum('ced_act',['0','1'])->default('1');
                $table->integer('ced_edo')->default('0'); ##### Estado de la cédula: 0=en construcción, 1=en revisión,  2=aprobado1, 3=en edicion, 4=en revisión, 5=público )

                $table->string('ced_urlurl');   ###### URL de la especie
                $table->foreign('ced_urlurl')->references('url_url')->on('sp_url')->onDelete('cascade')->constrained('sp_url','url_url');

                $table->string('ced_clencode'); ##### lengua
                ###### ojo, tuve que silenciar el foreign porque en la vista, clen_code no es key (se repiten base inali y base ethnologue)
                #$table->foreign('ced_clencode')->references('clen_code')->on('cat_lenguas')->onDelete('cascade')->constrained('cat_lenguas','clen_code');


                $table->string('ced_cjarsiglas'); ##### Jardín
                $table->foreign('ced_cjarsiglas')->references('cjar_siglas')->on('cat_jardines')->onDelete('cascade')->constrained('cat_jardines','cjar_siglas');



                $table->decimal('ced_version',5,2)->default('1.00'); ##### Versión de la cédula
                $table->date('ced_versiondate')->default(date('Y-m-d'));  ##### Fecha de la última versión

                $table->longText('ced_cita')->nullable(); ###### Texto de la cita de la ficha: Scheinvar GE y Gámez T, 2003. Algo....
                $table->text('ced_doi')->nullable();  ##### número doi

                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // --------------- En producción.  No borrar porque hay cédulas en producción
        // Schema::dropIfExists('sp_urlcedula');
    }
};
