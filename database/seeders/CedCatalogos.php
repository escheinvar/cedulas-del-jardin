<?php

namespace Database\Seeders;

use App\Models\ced_catalogos;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CedCatalogos extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $events=[
            ########## Catálogo de tipos de palabras clave de cédula
            ['cat_tipo'=>'alias', 'cat_valor'=>'Nombre común',  'cat_explica'=>''],
            ['cat_tipo'=>'alias', 'cat_valor'=>'Lengua',        'cat_explica'=>''],
            ['cat_tipo'=>'alias', 'cat_valor'=>'Palabra clave', 'cat_explica'=>''],
            ['cat_tipo'=>'parteuso', 'cat_valor'=>'', 'cat_explica'=>''],

            ######## Catálogo de uso de partes de planta
            ['cat_tipo'=>'parteplanta',   'cat_valor'=>'Raíz principal'],
            ['cat_tipo'=>'parteplanta',   'cat_valor'=>'Raíces secundarias'],
            ['cat_tipo'=>'parteplanta',   'cat_valor'=>'Tallo'],
            ['cat_tipo'=>'parteplanta',   'cat_valor'=>'Hojas'],
            ['cat_tipo'=>'parteplanta',   'cat_valor'=>'Flores'],
            ['cat_tipo'=>'parteplanta',   'cat_valor'=>'Frutos'],
            ['cat_tipo'=>'parteplanta',   'cat_valor'=>'Semillas'],
            ['cat_tipo'=>'parteplanta',   'cat_valor'=>'Yemas'],
            ['cat_tipo'=>'parteplanta',   'cat_valor'=>'Estípulas'],
            ['cat_tipo'=>'parteplanta',   'cat_valor'=>'Nodos'],
            ['cat_tipo'=>'parteplanta',   'cat_valor'=>'Brotes apicales'],
            ['cat_tipo'=>'parteplanta',   'cat_valor'=>'Brotes laterales'],
            ['cat_tipo'=>'parteplanta',   'cat_valor'=>'Bulbos'],
            ['cat_tipo'=>'parteplanta',   'cat_valor'=>'Rizomas'],
            ['cat_tipo'=>'parteplanta',   'cat_valor'=>'Tubérculos'],
            ['cat_tipo'=>'parteplanta',   'cat_valor'=>'Hoja cotiledonar'],
            ['cat_tipo'=>'parteplanta',   'cat_valor'=>'Espinas'],
            ['cat_tipo'=>'parteplanta',   'cat_valor'=>'Planta completa'],
            ['cat_tipo'=>'parteplanta',   'cat_valor'=>'Partes aéreas'],
            ['cat_tipo'=>'parteplanta',   'cat_valor'=>'Agallas'],
            ['cat_tipo'=>'parteplanta',   'cat_valor'=>'Corteza'],
            ['cat_tipo'=>'parteplanta',   'cat_valor'=>'Exudados'],
            ['cat_tipo'=>'parteplanta',   'cat_valor'=>'Inflorescencias'],
            ['cat_tipo'=>'parteplanta',   'cat_valor'=>'Infrutescencias'],
        ];

        if(ced_catalogos::count() == 0 ) {
            foreach ($events as $event){
                ced_catalogos::create($event);
            }
        }
    }
}
