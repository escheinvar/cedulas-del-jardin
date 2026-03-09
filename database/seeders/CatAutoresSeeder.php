<?php

namespace Database\Seeders;

use App\Models\cat_autores;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CatAutoresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $events=[
            [

                'caut_nombre'=>'Enrique',
                'caut_apellido1'=>'Scheinvar',
                'caut_apellido2'=>'Gottdiener',
                'caut_nombreautor'=>'Scheinvar E.',
                'caut_url'=>'scheinvare',
                'caut_cjarsiglas'=>'JebOax',
                'caut_correo'=>'escheinvar@gmail.com',
                'caut_institu'=>'Secihti/JebOax',
                'caut_usrid'=>'2',
                'caut_lenguas'=>'spa',
                'caut_web'=>'1', ### 1=si publica web, 0=no publica
                'caut_mailpublic'=>'1', ###1=si publica @ 0=no publica
                'caut_orcid'=>'0000-0002-0665-8298',
                // 'caut_img'=>null,
            ],[
                'caut_nombre'=>'Alejandro',
                'caut_apellido1'=>'De Ávila',
                'caut_apellido2'=>'Blomberg',
                'caut_nombreautor'=>'De Ávila A.',
                'caut_url'=>'deavila-blomberga',
                'caut_cjarsiglas'=>'JebOax',
                'caut_correo'=>'alejandro@correo.mx',
                'caut_institu'=>'JebOa',
                'caut_usrid'=>'',
                'caut_lenguas'=>'spa;zap',
                'caut_web'=>'1', ### 1=si publica web, 0=no publica
                'caut_mailpublic'=>'1', ###1=si publica @ 0=no publica
                // 'caut_img'=>null,
            ],[
                'caut_nombre'=>'Niza',
                'caut_apellido1'=>'Gámez',
                'caut_apellido2'=>'Tamariz',
                'caut_nombreautor'=>'Gámez-Tamariz N.',
                'caut_url'=>'gameztamarizn',
                'caut_cjarsiglas'=>'JebOax',
                'caut_correo'=>'nizagt@gmail.com',
                'caut_institu'=>'Secihti/JebOax',
                'caut_usrid'=>'',
                'caut_lenguas'=>'spa',
                'caut_web'=>'1', ### 1=si publica web, 0=no publica
                'caut_mailpublic'=>'1', ###1=si publica @ 0=no publica
                // 'caut_img'=>null,
            ],[
                'caut_nombre'=>'Noe',
                'caut_apellido1'=>'Pinzón',
                'caut_apellido2'=>'Palafox',
                'caut_nombreautor'=>'Pinzón-Palafox, N.',
                'caut_url'=>'pinzon-palafoxn',
                'caut_cjarsiglas'=>'JebOax',
                'caut_correo'=>'noe@y.que',
                'caut_institu'=>'',
                'caut_usrid'=>'',
                'caut_lenguas'=>'huv',
                'caut_web'=>'1', ### 1=si publica web, 0=no publica
                'caut_mailpublic'=>'0', ###1=si publica @ 0=no publica
                // 'caut_img'=>null,
            ],[
                'caut_nombre'=>'Juana',
                'caut_apellido1'=>'Mendoza',
                'caut_apellido2'=>'Ruiz',
                'caut_cjarsiglas'=>'JebOax',
                'caut_nombreautor'=>'Mendoza-Ruiz J.',
                'caut_url'=>'mendozaruizj',
                'caut_correo'=>'',
                'caut_institu'=>'Instituto de Investigaciones Filológicas, UNAM',
                'caut_usrid'=>'',
                'caut_lenguas'=>'',
                'caut_web'=>'0', ### 1=si publica web, 0=no publica
                'caut_mailpublic'=>'1', ###1=si publica @ 0=no publica
                // 'caut_img'=>null,
            ]
        ];

        if(cat_autores::count()=='0'){
            foreach ($events as $event){
                cat_autores::create($event);
            }
        }
    }
}
