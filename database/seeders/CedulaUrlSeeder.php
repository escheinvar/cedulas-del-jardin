<?php

namespace Database\Seeders;

use App\Models\CatJardinesModel;
use App\Models\cedulas_txt;
use App\Models\cedulas_url;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CedulaUrlSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ##################################### Genera cédula
        $events=[
            ['url_ccedtipo'=>'sp','url_cjarsiglas'=>'JebOax','url_url'=>'huaje',     'url_urltxt'=>'huaje',    'url_lencode'=>'spa', 'url_tradid'=>'0','url_titulo'=>'El huaje','url_tituloorig'=>'El huaje',  'url_resumen'=>'Resumen de la cédula','url_resumenorig'=>'Resumen de la cédula'],
            ['url_ccedtipo'=>'sp','url_cjarsiglas'=>'JebOax','url_url'=>'huaje_xta', 'url_urltxt'=>'huaje',    'url_lencode'=>'xta', 'url_tradid'=>'1','url_titulo'=>'El huaje','url_tituloorig'=>'El huaje',  'url_resumen'=>'Resumen de la cédula','url_resumenorig'=>'Resumen de la cédula'],
            ['url_ccedtipo'=>'sp','url_cjarsiglas'=>'JebOax','url_url'=>'huaje_zai', 'url_urltxt'=>'huaje',    'url_lencode'=>'zai', 'url_tradid'=>'1','url_titulo'=>'El huaje','url_tituloorig'=>'El huaje',  'url_resumen'=>'Resumen de la cédula','url_resumenorig'=>'Resumen de la cédula'],
            ['url_ccedtipo'=>'sp','url_cjarsiglas'=>'JebOax','url_url'=>'sabino',    'url_urltxt'=>'sabino',   'url_lencode'=>'xta', 'url_tradid'=>'0','url_titulo'=>'El sabino','url_tituloorig'=>'El sabino','url_resumen'=>'Resumen de la cédula','url_resumenorig'=>'Resumen de la cédula'],
            ['url_ccedtipo'=>'sp','url_cjarsiglas'=>'JebOax','url_url'=>'sabino_xta','url_urltxt'=>'sabino',   'url_lencode'=>'spa', 'url_tradid'=>'1','url_titulo'=>'El sabino','url_tituloorig'=>'El sabino','url_resumen'=>'Resumen de la cédula','url_resumenorig'=>'Resumen de la cédula'],
            ['url_ccedtipo'=>'sp','url_cjarsiglas'=>'JebOax','url_url'=>'sabino_maa','url_urltxt'=>'sabino',   'url_lencode'=>'maa', 'url_tradid'=>'1','url_titulo'=>'El sabino','url_tituloorig'=>'El sabino','url_resumen'=>'Resumen de la cédula','url_resumenorig'=>'Resumen de la cédula'],

            ['url_ccedtipo'=>'sp','url_cjarsiglas'=>'Matatlán','url_url'=>'huaje',     'url_urltxt'=>'huaje',    'url_lencode'=>'spa', 'url_tradid'=>'0','url_titulo'=>'El huaje','url_tituloorig'=>'El huaje',  'url_resumen'=>'Resumen de la cédula','url_resumenorig'=>'Resumen de la cédula'],
            ['url_ccedtipo'=>'sp','url_cjarsiglas'=>'Matatlán','url_url'=>'huaje_xta', 'url_urltxt'=>'huaje',    'url_lencode'=>'xta', 'url_tradid'=>'1','url_titulo'=>'El huaje','url_tituloorig'=>'El huaje',  'url_resumen'=>'Resumen de la cédula','url_resumenorig'=>'Resumen de la cédula'],
            ['url_ccedtipo'=>'sp','url_cjarsiglas'=>'Matatlán','url_url'=>'huaje_zai', 'url_urltxt'=>'huaje',    'url_lencode'=>'zai', 'url_tradid'=>'1','url_titulo'=>'El huaje','url_tituloorig'=>'El huaje',  'url_resumen'=>'Resumen de la cédula','url_resumenorig'=>'Resumen de la cédula'],
            ['url_ccedtipo'=>'sp','url_cjarsiglas'=>'Matatlán','url_url'=>'sabino',    'url_urltxt'=>'sabino',   'url_lencode'=>'xta', 'url_tradid'=>'0','url_titulo'=>'El sabino','url_tituloorig'=>'El sabino','url_resumen'=>'Resumen de la cédula','url_resumenorig'=>'Resumen de la cédula'],
            ['url_ccedtipo'=>'sp','url_cjarsiglas'=>'Matatlán','url_url'=>'sabino_xta','url_urltxt'=>'sabino',   'url_lencode'=>'spa', 'url_tradid'=>'1','url_titulo'=>'El sabino','url_tituloorig'=>'El sabino','url_resumen'=>'Resumen de la cédula','url_resumenorig'=>'Resumen de la cédula'],
            ['url_ccedtipo'=>'sp','url_cjarsiglas'=>'Matatlán','url_url'=>'sabino_maa','url_urltxt'=>'sabino',   'url_lencode'=>'maa', 'url_tradid'=>'1','url_titulo'=>'El sabino','url_tituloorig'=>'El sabino','url_resumen'=>'Resumen de la cédula','url_resumenorig'=>'Resumen de la cédula'],

        ];

        if (cedulas_url::count() == 0 ) {
            foreach ($events as $event){
                cedulas_url::create($event);
            }
        }

        ##################################### Genera contenido de cédulas:
        if(cedulas_txt::count() == 0){
            foreach(['JebOax'] as $jardin){
                foreach(['huaje','huaje_xta', 'huaje_zai'] as $url){
                    $parrafo1=fake()->paragraph();$parrafo3=fake()->paragraph();$parrafo2=fake()->paragraph();
                    $events=[
                        ['txt_cjarsiglas'=>$jardin, 'txt_urlurl'=>$url,'txt_tipo'=>'h1','txt_orden'=>'1', 'txt_txt'=>'El título primero', 'txt_txtoriginal'=>'El título primero', 'txt_audio'=>'/aud/JebOax_inicio1.000.ogg'],
                        ['txt_cjarsiglas'=>$jardin, 'txt_urlurl'=>$url,'txt_tipo'=>'p', 'txt_orden'=>'2', 'txt_txt'=>$parrafo1,           'txt_txtoriginal'=>$parrafo1,           'txt_audio'=>'/aud/JebOax_inicio1.000.ogg'],
                        ['txt_cjarsiglas'=>$jardin, 'txt_urlurl'=>$url,'txt_tipo'=>'h2','txt_orden'=>'3', 'txt_txt'=>'El título segundo', 'txt_txtoriginal'=>'El título primero', 'txt_audio'=>'/aud/JebOax_inicio1.000.ogg'],
                        ['txt_cjarsiglas'=>$jardin, 'txt_urlurl'=>$url,'txt_tipo'=>'p', 'txt_orden'=>'4', 'txt_txt'=>$parrafo2,           'txt_txtoriginal'=>$parrafo2,           'txt_audio'=>'/aud/JebOax_inicio1.000.ogg'],
                        ['txt_cjarsiglas'=>$jardin, 'txt_urlurl'=>$url,'txt_tipo'=>'h3','txt_orden'=>'5', 'txt_txt'=>'El título tercero', 'txt_txtoriginal'=>'El título primero', 'txt_audio'=>'/aud/JebOax_inicio1.000.ogg'],
                        ['txt_cjarsiglas'=>$jardin, 'txt_urlurl'=>$url,'txt_tipo'=>'p', 'txt_orden'=>'6', 'txt_txt'=>$parrafo3,           'txt_txtoriginal'=>$parrafo3,           'txt_audio'=>'/aud/JebOax_inicio1.000.ogg'],
                    ];
                    foreach ($events as $event){
                        cedulas_txt::create($event);
                    }
                }
            }





        }
    }
}
