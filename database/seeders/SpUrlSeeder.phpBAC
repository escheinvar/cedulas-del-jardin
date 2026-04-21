<?php

namespace Database\Seeders;

use App\Models\SpUrlModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SpUrlSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $events=[
            ['url_url'=>'huaje',             'url_nombre'=>'Huaje',              'url_reino'=>'pl',  'url_sp'=>'2346297', 'url_nombrecomun'=>'Huaje'            ,  'url_sciname'=>'' ],
            ['url_url'=>'sabino',            'url_nombre'=>'Sabino',             'url_reino'=>'pl',  'url_sp'=>'378578',  'url_nombrecomun'=>'Sabino, Ahuehuete',  'url_sciname'=>'' ],
            ['url_url'=>'abejasinaguijon',   'url_nombre'=>'Abejas sin aguijón', 'url_reino'=>'an',  'url_sp'=>'1',       'url_nombrecomun'=>'Abejas sin aguijón', 'url_sciname'=>'' ],
            ['url_url'=>'grana',             'url_nombre'=>'Grana cochinilla',   'url_reino'=>'an',  'url_sp'=>'2',       'url_nombrecomun'=>'Grana cochinilla',   'url_sciname'=>'' ],
        ];

        if(SpUrlModel::count()=='0'){
            foreach ($events as $event){
                ##### En producción
                SpUrlModel::create($event);
            }
        }
    }
}
