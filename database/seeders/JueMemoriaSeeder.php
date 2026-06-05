<?php

namespace Database\Seeders;

use App\Models\cedulas_url;
use App\Models\jue_memoria;
use App\Models\juegos;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JueMemoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ############################### Cédulas en español
        $JuegoDeCartas=[
            [
                'titulo'=>'Las cédulas en español',
                'jardin'=>'IxMxJebOax',
                'Autor'=>'Enrique Scheinvar',
                'lengua'=>'spa',
            ],[
                'titulo'=>'Las cédulas en én-ná (mazateco)',
                'jardin'=>'IxMxJebOax',
                'Autor'=>'Enrique Scheinvar y Gabriela ',
                'lengua'=>'maa',
            ],[
                'titulo'=>'Las cédulas en ditza dixza(zapoteco de Tlacolula)',
                'jardin'=>'IxMxJebOax',
                'Autor'=>'Enrique Scheinvar y Gabriela ',
                'lengua'=>'zab',
            ],[
                'titulo'=>'Las cédulas en ayuuk (mixe)',
                'jardin'=>'IxMxJebOax',
                'Autor'=>'Enrique Scheinvar y Gabriela ',
                'lengua'=>'neq',
            ],
        ];



        foreach($JuegoDeCartas as $jue){
            $hay = juegos::where('jue_name',$jue['titulo'])->count();
            if($hay < '1'){
                #####Crea juego:
                $dato=juegos::create([
                    'jue_cjarsiglas'=>$jue['jardin'],
                    'jue_tipo'=>'memoria',
                    'jue_name'=>$jue['titulo'],
                    'jue_cita'=>$jue['titulo'].', por '.$jue['Autor'].'. '.date('Y'),
                    'jue_cita_aut'=>$jue['Autor'],
                    'jue_anio'=>date('Y'),
                ]);
                ##### Crea cartas
                $num='0';
                $cartas=cedulas_url::where('url_act','1')->where('url_del','0')
                        ->where('url_lencode',$jue['lengua'])
                        ->with('objetos')->with('lenguas')
                        ->get();
                foreach($cartas as $c){
                    $num=$num+1;
                    jue_memoria::create([
                        'mem_jueid'=>$dato->jue_id,
                        'mem_name'=>$dato->jue_name,
                        'mem_par'=>$num,
                        'mem_txt'=>$c->url_titulo,
                        'mem_img'=>null,
                        'mem_aud'=>$c->url_audiotitulo,
                    ]);
                    jue_memoria::create([
                        'mem_jueid'=>$dato->jue_id,
                        'mem_name'=>$dato->jue_name,
                        'mem_par'=>$num,
                        'mem_txt'=>null,
                        'mem_img'=>$c->objetos->where('img_cimgtipo','portada')->value('img_file'),
                        'mem_aud'=>$c->url_audiotitulo,
                    ]);
                }
            }
        }


        ########################################### Sólo imágenes
        $hay = juegos::where('jue_name','Ejemplares del Jardín')->count();
        if($hay < '1'){
            #####Crea juego:
            $dato=juegos::create([
                'jue_cjarsiglas'=>'IxMxJebOax',
                'jue_tipo'=>'memoria',
                'jue_name'=>'Imágenes de ejemplares',
                'jue_cita'=>'Imágenes de ejemplares, por Enrique Scheinvar. '.date('Y'),
                'jue_cita_aut'=>'Enrique Scheinvar',
                'jue_anio'=>date('Y'),
            ]);
            ##### Crea cartas
            $num='0';
            $cartas=cedulas_url::where('url_act','1')->where('url_del','0')
                    ->where('url_tradid','0')
                    ->with('objetos')->with('lenguas')
                    ->get();
            foreach($cartas as $c){
                $num=$num+1;
                jue_memoria::create([
                    'mem_jueid'=>$dato->jue_id,
                    'mem_name'=>$dato->jue_name,
                    'mem_par'=>$num,
                    'mem_txt'=>null,
                    'mem_img'=>$c->objetos->where('img_cimgtipo','portada')->value('img_file'),
                    'mem_aud'=>null,
                ]);
                jue_memoria::create([
                    'mem_jueid'=>$dato->jue_id,
                    'mem_name'=>$dato->jue_name,
                    'mem_par'=>$num,
                    'mem_txt'=>null,
                    'mem_img'=>$c->objetos->where('img_cimgtipo','portada')->value('img_file'),
                    'mem_aud'=>null,
                ]);
            }
        }
        ########################################### Sólo imágenes
        $hay = juegos::where('jue_name','Ejemplares del Jardín')->count();
        if($hay < '1'){
            #####Crea juego:
            $dato=juegos::create([
                'jue_cjarsiglas'=>'IxMxJebOax',
                'jue_tipo'=>'memoria',
                'jue_name'=>'Nombres científicos de ejemplares',
                'jue_cita'=>'Nombres científicos de ejemplares, por Enrique Scheinvar. '.date('Y'),
                'jue_cita_aut'=>'Enrique Scheinvar',
                'jue_anio'=>date('Y'),
            ]);
            ##### Crea cartas
            $num='0';
            $cartas=cedulas_url::where('url_act','1')->where('url_del','0')
                    ->where('url_tradid','0')
                    ->with('objetos')->with('lenguas')->with('especies')
                    ->get();

            foreach($cartas as $c){
                $num=$num+1;
                jue_memoria::create([
                    'mem_jueid'=>$dato->jue_id,
                    'mem_name'=>$dato->jue_name,
                    'mem_par'=>$num,
                    'mem_txt'=>null,
                    'mem_img'=>$c->objetos->where('img_cimgtipo','portada')->value('img_file'),
                    'mem_aud'=>null,
                ]);
                jue_memoria::create([
                    'mem_jueid'=>$dato->jue_id,
                    'mem_name'=>$dato->jue_name,
                    'mem_par'=>$num,
                    'mem_txt'=>implode(', ',$c->especies->pluck('sp_scname')->toArray()),
                    'mem_img'=>null,
                    'mem_aud'=>null,
                ]);
            }
        }


        // ################### Juego de cartas
        // $hay = juegos::where('jue_name','El abecedario')->count();
        // if($hay < '1'){
        //     $cartas=['a','b','c','d','e','f','g','h','i','j','k','l'];
        //     $jue=juegos::create([
        //         'jue_cjarsiglas'=>'IxMxJebOax',
        //         'jue_tipo'=>'memoria',
        //         'jue_name'=>'El abecedario',
        //         'jue_cita'=>'Memoria el Abecedario, por Enrique Scheinvar',
        //         'jue_cita_aut'=>'scheinvar, E.',
        //         'jue_anio'=>'2026',
        //     ]);
        //     $num='0';
        //     foreach($cartas as $c){
        //         $num=$num+1;
        //         jue_memoria::create([
        //             'mem_jueid'=>$jue->jue_id,
        //             'mem_name'=>$jue->jue_name,
        //             'mem_par'=>$num,
        //             'mem_txt'=>$c,
        //             'mem_img'=>null,
        //             'mem_aud'=>null,
        //         ]);
        //         jue_memoria::create([
        //             'mem_jueid'=>$jue->jue_id,
        //             'mem_name'=>$jue->jue_name,
        //             'mem_par'=>$num,
        //             'mem_txt'=>$c,
        //             'mem_img'=>null,
        //             'mem_aud'=>null,
        //         ]);

        //     }
        // }
    }
}
