<?php

namespace Database\Seeders;

use App\Models\CatCampusModel;
use App\Models\CatJardinesModel;
use App\Models\jardin_url;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CatJardinesCampusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $events=[
            [
                'cjar_id'=>'1',
                'cjar_name'=>'Etnobiológico de Oaxaca',
                'cjar_nombre'=>'Jardín Etnobiológico de Oaxaca',
                'cjar_siglas'=>'JebOax',
                'cjar_tipo'=>'Etnobiológico',
                'cjar_direccion'=>'Reforma s/n, Independencia, Centro, Oaxaca de Juárez, Oaxaca. C.P. 68000 ',
                'cjar_tel'=>' 951 516 5325',
                'cjar_mail'=>'etnobotanico@infinitummail.com',
                'cjar_edo'=>'Oaxaca',
                'cjar_logo'=>'/avatar/jardines/JebOax.png',
            ],[
                'cjar_id'=>'2',
                'cjar_name'=>'Matatlán',
                'cjar_nombre'=>'Jardín Comunitario de Matatlán',
                'cjar_siglas'=>'Matatlán',
                'cjar_tipo'=>'Etnobotánico',
                'cjar_direccion'=>'Reforma s/n, Independencia, Centro, Oaxaca de Juárez, Oaxaca. C.P. 68000 ',
                'cjar_tel'=>' 951 516 5325',
                'cjar_mail'=>'etnobotanico@infinitummail.com',
                'cjar_edo'=>'Oaxaca',
                'cjar_logo'=>'/avatar/jardines/Matatlan.png',
            ],[
                'cjar_id'=>'3',
                'cjar_name'=>'IxMx en JebOax',
                'cjar_nombre'=>'Investigadores por México en el Jardín Etnobiológico de Oaxaca',
                'cjar_siglas'=>'IxMxJebOax',
                'cjar_tipo'=>'Etnobiológico',
                'cjar_direccion'=>'SN',
                'cjar_tel'=>'5515139080',
                'cjar_mail'=>'jardinetnobiologicodeoaxaca@gmail.com',
                'cjar_edo'=>'Oaxaca',
                'cjar_logo'=>'/avatar/jardines/IxMxJebOax.png',
            ]
        ];
        if(CatJardinesModel::count()=='0'){
            foreach ($events as $event){
                CatJardinesModel::create($event);
            }
        }

        $events=[
            [
                'urlj_cjarsiglas'=>'JebOax',
                'urlj_url'=>'inicio',
                'urlj_act'=>'0',
                'urlj_titulo'=>'Jardín Etnobiológico de Oaxaca',
                'urlj_descrip'=>'Página del  en el Sistema de Cédulas del Jardín en lenguas originarias',
                'urlj_bannertitle'=>'Jardín Etnobiológico de Oaxaca',
            ],[
                'urlj_cjarsiglas'=>'Matatlán',
                'urlj_url'=>'inicio',
                'urlj_act'=>'0',
                'urlj_titulo'=>'Jardín comunitario de Santiago Matatlán',
                'urlj_descrip'=>'Página del  en el Sistema de Cédulas del Jardín en lenguas originarias',
                'urlj_bannertitle'=>'Jardín comunitario de Santiago Matatlán',
            ],[
                'urlj_cjarsiglas'=>'IxMxJebOax',
                'urlj_url'=>'inicio',
                'urlj_act'=>'0',
                'urlj_titulo'=>'Investigadores por México en el JebOax',
                'urlj_descrip'=>'Página del  en el Sistema de Cédulas del Jardín en lenguas originarias',
                'urlj_bannertitle'=>'Investigadores por México en el JebOax',
            ],
        ];

        if(jardin_url::count()=='0'){
            foreach ($events as $event){
                jardin_url::create($event);
            }
        }
    }
}
