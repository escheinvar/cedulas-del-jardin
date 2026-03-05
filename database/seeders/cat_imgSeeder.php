<?php

namespace Database\Seeders;

use App\Models\cat_img;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class cat_imgSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $events=[
            // ['cimg_modulo'=>'jardin','cimg_tipo'=>'banner'],
            ['cimg_modulo'=>'jardin','cimg_tipo'=>'web'],
            ['cimg_modulo'=>'autor', 'cimg_tipo'=>'portada'],
            ['cimg_modulo'=>'autor', 'cimg_tipo'=>'web'],
            ['cimg_modulo'=>'cedula','cimg_tipo'=>'portada'],
            ['cimg_modulo'=>'cedula','cimg_tipo'=>'lateral'],
            ['cimg_modulo'=>'cedula','cimg_tipo'=>'ppal1'],
            ['cimg_modulo'=>'cedula','cimg_tipo'=>'ppal2'],
            ['cimg_modulo'=>'cedula','cimg_tipo'=>'ppal3'],
            ['cimg_modulo'=>'cedula','cimg_tipo'=>'ppal'],
            ['cimg_modulo'=>'cedula','cimg_tipo'=>'lat1'],
            ['cimg_modulo'=>'cedula','cimg_tipo'=>'lat2'],
            ['cimg_modulo'=>'cedula','cimg_tipo'=>'lat3'],
            ['cimg_modulo'=>'cedula','cimg_tipo'=>'lat4'],
            ['cimg_modulo'=>'cedula','cimg_tipo'=>'lat5'],
            ['cimg_modulo'=>'cedula','cimg_tipo'=>'lat'],
            ['cimg_modulo'=>'cedula','cimg_tipo'=>'web'],
            ['cimg_modulo'=>'cedula','cimg_tipo'=>'pie'],

        ];
        if(cat_img::count()=='0'){
            foreach ($events as $event){
                cat_img::create($event);
            }
        }
    }
}
