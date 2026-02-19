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
        if(!Schema::hasTable('cat_lenguas_inali')){
            Schema::create('cat_lenguas_inali', function (Blueprint $table) {
                $table->id('clen2_id');
                $table->string('clen2_lengua'); ##### Nombre de la lengua, variante en español sensu inali, 2008
                $table->string('clen2_autonimia')->nullable(); ##### Nombre,de la lengua según la propia lengua,
                $table->longText('clen2_localidad')->nullable();  ##### Nombre de localidad de referencia
                $table->string('clen2_usuarios')->nullable();   ##### Número de comunidades en el mapa de conabio según inali
                #$table->string('clen2_status')->nullable();   ##### Status sensu etnolog
                #$table->string('clen2_altnames')->nullable(); ##### Nombres alternativos
                #$table->string('clen2_clasifica')->nullable();
                #$table->integer('clen2_originario');    ##### Indica si es 1 o no 0 lengua de pueblo originario
                $table->string('clen2_code')->nullable();  ##### Código de ethnologue de la lengua (ninguno, uno o más)
                $table->integer('clen2_fam')->nullable();  ###### Código de la familia de ethnologue (https://www.ethnologue.com/subgroup/#/)
                $table->integer('clen2_rama')->nullable(); ###### Código de la rama de ethnologue (https://www.ethnologue.com/subgroup/#/)
                $table->integer('clen2_subgroup')->nullable(); ###### Código del subgrupo más cercano sensu ethnologue (https://www.ethnologue.com/subgroup/#/)

                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cat_lenguas_inali CASCADE');
    }
};
