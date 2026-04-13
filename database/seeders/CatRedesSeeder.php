<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\cat_redes;

class CatRedesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $events=[
            ['red_name'=>'Cedulas del Jardín', 'red_url'=>url('/'),           'red_icon'=>'<img src="/imagenes/logo-nav.png" style="width:20px;">'],
            ['red_name'=>'Sitio web','red_url'=>'',                           'red_icon'=>'<i class="bi bi-globe"></i>'],
            ['red_name'=>'Facebook', 'red_url'=>'https://www.facebook.com/',  'red_icon'=>'<i class="bi bi-facebook"></i>'],
            ['red_name'=>'Instagram', 'red_url'=>'https://www.instagram.com/','red_icon'=>'<i class="bi bi-instagram"></i>'],
            ['red_name'=>'Youtube',  'red_url'=>'https://www.youtube.com/',   'red_icon'=>'<i class="bi bi-youtube"></i>'],
            ['red_name'=>'Tiktok',   'red_url'=>'https://www.tiktok.com/',    'red_icon'=>'<i class="bi bi-tiktok"></i>'],
            ['red_name'=>'X',        'red_url'=>'https://x.com/',             'red_icon'=>'<i class="bi bi-twitter-x"></i>'],
            ['red_name'=>'Pinterest','red_url'=>'https://mx.pinterest.com/',  'red_icon'=>'<i class="bi bi-pinterest"></i>'],
        ];

        if (cat_redes::count() == 0 ) {
            foreach ($events as $event){
                cat_redes::create($event);
            }
        }
    }
}
