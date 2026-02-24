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
        Schema::create('cat_autores', function (Blueprint $table) {
            $table->id('caut_id');
            $table->enum('caut_act',['0','1'])->default('1');  ##### borrado lógico inactivo
            $table->enum('caut_del',['0','1'])->default('0'); ##### borrado lógico
            $table->enum('caut_tipo',['Autor','Traductor','AutorTraductor','Comunidad'])->default('Autor');
            $table->string('caut_nombre');
            $table->string('caut_apellidos');
            $table->string('caut_nombreautor');
            $table->string('caut_correo')->nullable();
            $table->string('caut_institu')->nullable();
            $table->string('caut_usrid')->nullable();
            $table->enum('caut_web',['0','1'])->default('0'); ##### flag de existencia de web
            $table->enum('caut_mailpublic',['0','1'])->default('0'); ##### flag de autorización para publicar datos
            $table->string('caut_orcid')->nullable(); #### Número identificador de autor académico (orcid)
            $table->string('caut_img')->nullable(); ##### Ruta al archivo de imagen del autor
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cat_autores');
    }
};
