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
                'caut_correo'=>'escheinvar@gmail.com',
                'caut_institu'=>'Secihti/JebOax',
                'caut_usrid'=>'2',
                'caut_mailpublic'=>'1', ###1=si publica @ 0=no publica
                'caut_orcid'=>'0000-0002-0665-8298',
                'caut_scopus'=>'55636465200',
                'caut_isni'=>'0000000049333253',
                'caut_google'=>'https://scholar.google.es/citations?user=EAjudjwAAAAJ&hl=es&oi=ao',
                'caut_rgate'=>'https://www.researchgate.net/profile/Enrique-Scheinvar',
            ],[
                'caut_nombre'=>'Alejandro',
                'caut_apellido1'=>'de Ávila',
                'caut_apellido2'=>'Blomberg',
                'caut_nombreautor'=>'De Ávila A.',
                'caut_url'=>'deavila-blomberga',
                'caut_correo'=>'',
                'caut_institu'=>'JebOax',
                'caut_usrid'=>null,
                'caut_orcid'=>'0009-0003-7569-8423',
                'caut_scopus'=>'55561105200',
                'caut_isni'=>'0000000073304014',
                'caut_google'=>'https://scholar.google.es/citations?hl=es&user=qj3w18MAAAAJ',
                'caut_rgate'=>'https://www.researchgate.net/profile/Alejandro-De-Avila-2',
                'caut_mailpublic'=>'1', ###1=si publica @ 0=no publica
            ],[
                'caut_nombre'=>'Niza',
                'caut_apellido1'=>'Gámez',
                'caut_apellido2'=>'Tamariz',
                'caut_nombreautor'=>'Gámez-Tamariz N.',
                'caut_url'=>'gameztamarizn',
                'caut_correo'=>'nizagt@gmail.com',
                'caut_institu'=>'Secihti/JebOax',
                'caut_usrid'=>null,
                'caut_mailpublic'=>'1', ###1=si publica @ 0=no publica
                'caut_orcid'=>'0000-0001-7929-2859',
                'caut_scopus'=>'',
                'caut_isni'=>'',
                'caut_google'=>'https://scholar.google.es/citations?hl=es&user=FiNVIw8AAAAJ',
                'caut_rgate'=>'https://www.researchgate.net/profile/Niza-Gamez-2',
            ]
        ];

        if(cat_autores::count()=='0'){
            foreach ($events as $event){
                cat_autores::create($event);
            }
        }
    }
}
