<?php

namespace Database\Seeders;

use App\Models\proy_archivos;
use App\Models\proy_proyectos;
use App\Models\proy_estado;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Proyectos extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $events=[
            ########## Catálogo de tipos de palabras clave de cédula
         ];

        //   foreach ($events as $event){
            $proy=proy_proyectos::create([
                'proy_titulo'=>'Proyecto de prueba',
                'proy_jardin'=>'JebOax',
                'proy_autor'=>'2',
            ]);
            $edo=proy_estado::create([
                'predo_proyid' => $proy->proy_id,
                'predo_edo'=>'0.0',
                'predo_estado'=>'Recibido por admin',
                'predo_comentario'=>'Proyecto creado',
            ]);
            proy_archivos::create([
                'prmat_proyid' => $proy->proy_id,
                'prmat_predoid' => $edo->predo_id,
                'prmat_archivo'=>'JebOax_$proy_id_'.date('Y-m-d').'_formato.pdf',
                'prmat_nombrearch'=>'formato.pdf',
                'prmat_tipo'=>'formato',
                'prmat_usr'=>2,
            ]);
            proy_archivos::create([
                'prmat_proyid' => $proy->proy_id,
                'prmat_predoid' => $edo->predo_id,
                'prmat_archivo'=>'JebOax_$proy_id_'.date('Y-m-d').'_solicitud.pdf',
                'prmat_nombrearch'=>'solicitud.pdf',
                'prmat_tipo'=>'solicitud',
                'prmat_usr'=>2,
            ]);
            proy_archivos::create([
                'prmat_proyid' => $proy->proy_id,
                'prmat_predoid' => $edo->predo_id,
                'prmat_archivo'=>'JebOax_$proy_id_'.date('Y-m-d').'_principal.pdf',
                'prmat_nombrearch'=>'LasHormigasDelJardin.pdf',
                'prmat_tipo'=>'txt',
                'prmat_usr'=>2,
            ]);
        //   }
    }
}
