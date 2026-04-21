<?php

namespace Database\Seeders;

use App\Models\SpFotosModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SpFotosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {


        $events=[
            //Huaje
            ['imgsp_urlurl'=>'huaje',            'imgsp_cjarsiglas'=>'JebOax',    'imgsp_cimgname'=>'portada',    'imgsp_file'=>'huaje_portada.webp'],
            ['imgsp_urlurl'=>'huaje',            'imgsp_cjarsiglas'=>'JebOax',    'imgsp_cimgname'=>'ppal1',      'imgsp_file'=>'huaje_principal_1.webp'],
            ['imgsp_urlurl'=>'huaje',            'imgsp_cjarsiglas'=>'JebOax',    'imgsp_cimgname'=>'ppal2',      'imgsp_file'=>'huaje_principal_2.webp'],
            ['imgsp_urlurl'=>'huaje',            'imgsp_cjarsiglas'=>'JebOax',    'imgsp_cimgname'=>'ppal3',      'imgsp_file'=>'huaje_principal_3.jpg'],
            ['imgsp_urlurl'=>'huaje',            'imgsp_cjarsiglas'=>'JebOax',    'imgsp_cimgname'=>'ppal4',      'imgsp_file'=>'huaje_principal_4.jpeg'],
            ['imgsp_urlurl'=>'huaje',            'imgsp_cjarsiglas'=>'JebOax',    'imgsp_cimgname'=>'lateral1',   'imgsp_file'=>'huaje_lateral_1.webp'],
            ['imgsp_urlurl'=>'huaje',            'imgsp_cjarsiglas'=>'JebOax',    'imgsp_cimgname'=>'lateral2',   'imgsp_file'=>'huaje_lateral_2.jpg'],
            //Sabino
            ['imgsp_urlurl'=>'sabino',           'imgsp_cjarsiglas'=>'JebOax',    'imgsp_cimgname'=>'portada',    'imgsp_file'=>'sabino_portada.webp'],
            ['imgsp_urlurl'=>'sabino',           'imgsp_cjarsiglas'=>'JebOax',    'imgsp_cimgname'=>'ppal1',      'imgsp_file'=>'sabino_principal_1.webp'],
            ['imgsp_urlurl'=>'sabino',           'imgsp_cjarsiglas'=>'JebOax',    'imgsp_cimgname'=>'ppal2',      'imgsp_file'=>'sabino_principal_2.webp'],
            ['imgsp_urlurl'=>'sabino',           'imgsp_cjarsiglas'=>'JebOax',    'imgsp_cimgname'=>'lateral1',   'imgsp_file'=>'sabino_lateral1.webp'],
            ['imgsp_urlurl'=>'sabino',           'imgsp_cjarsiglas'=>'JebOax',    'imgsp_cimgname'=>'lateral2',   'imgsp_file'=>'sabino_lateral_2.jpeg'],
            //Meliponas
            ['imgsp_urlurl'=>'abejasinaguijon',  'imgsp_cjarsiglas'=>'JebOax',    'imgsp_cimgname'=>'portada',    'imgsp_file'=>'melipona_portada.jpg'],
            ['imgsp_urlurl'=>'abejasinaguijon',  'imgsp_cjarsiglas'=>'JebOax',    'imgsp_cimgname'=>'ppal1',      'imgsp_file'=>'melipona_principal1.jpg'],
            ['imgsp_urlurl'=>'abejasinaguijon',  'imgsp_cjarsiglas'=>'JebOax',    'imgsp_cimgname'=>'ppal2',      'imgsp_file'=>'melipona_principal2.jpg'],
            ['imgsp_urlurl'=>'abejasinaguijon',  'imgsp_cjarsiglas'=>'JebOax',    'imgsp_cimgname'=>'ppal3',      'imgsp_file'=>'melipona_principal3.jpg'],
            ['imgsp_urlurl'=>'abejasinaguijon',  'imgsp_cjarsiglas'=>'JebOax',    'imgsp_cimgname'=>'lateral1',   'imgsp_file'=>'melipona_lateral1.jpg'],
            ['imgsp_urlurl'=>'abejasinaguijon',  'imgsp_cjarsiglas'=>'JebOax',    'imgsp_cimgname'=>'lateral2',   'imgsp_file'=>'melipona_lateral2.jpg'],
            ['imgsp_urlurl'=>'abejasinaguijon',  'imgsp_cjarsiglas'=>'JebOax',    'imgsp_cimgname'=>'lateral3',   'imgsp_file'=>'melipona_lateral3.jpg'],
            //grana
            ['imgsp_urlurl'=>'grana',            'imgsp_cjarsiglas'=>'JebOax',    'imgsp_cimgname'=>'portada',    'imgsp_file'=>'grana_portada.jpg'],
            ['imgsp_urlurl'=>'grana',            'imgsp_cjarsiglas'=>'JebOax',    'imgsp_cimgname'=>'ppal1',      'imgsp_file'=>'grana_principal1.jpg'],
            ['imgsp_urlurl'=>'grana',            'imgsp_cjarsiglas'=>'JebOax',    'imgsp_cimgname'=>'ppal2',      'imgsp_file'=>'grana_principal2.jpg'],
            ['imgsp_urlurl'=>'grana',            'imgsp_cjarsiglas'=>'JebOax',    'imgsp_cimgname'=>'ppal3',      'imgsp_file'=>'grana_principal3.jpg'],
            ['imgsp_urlurl'=>'grana',            'imgsp_cjarsiglas'=>'JebOax',    'imgsp_cimgname'=>'ppal4',      'imgsp_file'=>'grana_principal4.jpg'],
            ['imgsp_urlurl'=>'grana',            'imgsp_cjarsiglas'=>'JebOax',    'imgsp_cimgname'=>'lateral1',   'imgsp_file'=>'grana_lateral1.jpg'],
            ['imgsp_urlurl'=>'grana',            'imgsp_cjarsiglas'=>'JebOax',    'imgsp_cimgname'=>'lateral2',   'imgsp_file'=>'grana_lateral2.jpg'],
            ['imgsp_urlurl'=>'grana',            'imgsp_cjarsiglas'=>'JebOax',    'imgsp_cimgname'=>'lateral3',   'imgsp_file'=>'grana_lateral3.jpg'],

        ];

        if(SpFotosModel::count()=='0'){
            foreach ($events as $event){
                ##### En producción
                SpFotosModel::create($event);
            }
        }
    }
}
