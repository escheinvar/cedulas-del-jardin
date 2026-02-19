<?php

namespace Database\Seeders;

use App\Models\CatCampusModel;
use App\Models\CatJardinesModel;
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
                'cjar_logo'=>'JebOax.png',
            ],[
                'cjar_id'=>'2',
                'cjar_name'=>'Matatlan',
                'cjar_nombre'=>'Jardín Comunitario de Matatlán',
                'cjar_siglas'=>'JM',
                'cjar_tipo'=>'Etnobotánico',
                'cjar_direccion'=>'Reforma s/n, Independencia, Centro, Oaxaca de Juárez, Oaxaca. C.P. 68000 ',
                'cjar_tel'=>' 951 516 5325',
                'cjar_mail'=>'etnobotanico@infinitummail.com',
                'cjar_edo'=>'Oaxaca',
                'cjar_logo'=>'Matatlan.png',
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
                'cjar_logo'=>'IxMxJebOax.png',
            ]
        ];
        if(CatJardinesModel::count()=='0'){
            foreach ($events as $event){
                CatJardinesModel::create($event);
            }
        }

        $events=[
            [
                'ccam_id'=>'1',
                'ccam_act'=>'1',
                'ccam_cjarid'=>'1',
                'ccam_name'=>'Santo Domingo',
                'ccam_nombre'=>'Santo Domingo',
                'ccam_direccion'=>'',
            ],[
                'ccam_id'=>'2',
                'ccam_act'=>'1',
                'ccam_cjarid'=>'1',
                'ccam_name'=>'Canteras',
                'ccam_nombre'=>'Canteras',
                'ccam_direccion'=>'',
            ],[
                'ccam_id'=>'3',
                'ccam_act'=>'1',
                'ccam_cjarid'=>'2',
                'ccam_name'=>'Presa',
                'ccam_nombre'=>'Presa',
                'ccam_direccion'=>'',
            ],[
                'ccam_id'=>'4',
                'ccam_act'=>'1',
                'ccam_cjarid'=>'3',
                'ccam_name'=>'IxMx JebOax',
                'ccam_nombre'=>'Investigadores por México en el Jardín Etnobiológico de Oaxaca',
                'ccam_direccion'=>'S/N',
            ]
        ];
        if(CatCampusModel::count()=='0'){
            foreach ($events as $event){
                CatCampusModel::create($event);
            }
        }
    }
}
