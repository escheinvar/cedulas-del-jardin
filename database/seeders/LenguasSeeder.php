<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\lenguas;

class LenguasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $events=[
            ['len_code'=>'spa', 'len_lengua'=>'Español',                        'len_variante'=>'',         'len_autonimias'=>'Español',       'len_altnames'=>'Español'],
            ['len_code'=>'xta', 'len_lengua'=>'Mixteco, Alcozauca',             'len_variante'=>'',         'len_autonimias'=>'Tu̱’un sâvi',    'len_altnames'=>'Mixteco de Alocozauca, Mixteco de Xochapa.'],
            ['len_code'=>'maa', 'len_lengua'=>'Mazateco, San Jerónimo Tecóatl', 'len_variante'=>'',         'len_autonimias'=>'ꞌÉn-ná',        'len_altnames'=>'Enna, Huautla-Mazatlán Masateko, Masateko, Mazatec, Mazateco, Mazateco de Mazatlán, Mazateco de Tecóatl, Mazateco de la sierra, Mazateco del Oeste, Mazatèque de Mazatlán, Mazatèque des hautes terres, Northern Highland Mazatec.'],
            ['len_code'=>'huv', 'len_lengua'=>'Huave, San Mateo del Mar',       'len_variante'=>'',         'len_autonimias'=>'Ombeayiüts',    'len_altnames'=>'Huave, Huave del Oeste.'],
            ['len_code'=>'zai', 'len_lengua'=>'Zapoteco, Istmo',                'len_variante'=>'Juchitán', 'len_autonimias'=>'Didxazá',       'len_altnames'=>'Juchitán Zapotec, Sapoteko, Zapoteco Istmeño, Zapoteco de la Planicie Costera, Zapoteco del Istmo.'],
         ];


        if(lenguas::count()=='0'){
            foreach ($events as $event){
                ##### En producción
                lenguas::create($event);
            }
        }
    }
}
