<?php

namespace Database\Seeders;

use App\Models\SpAporteUsrsModel;
use App\Models\SpUrlCedulaModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SpAporteUsrsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $events=SpUrlCedulaModel::get('ced_id');


        #if(SpAporteUsrsModel::count()=='0'){
            foreach ($events as $event){
                ##### En producción
                SpAporteUsrsModel::create([
                    'msg_edo'=>'3',
                    'msg_cedid'=>$event->ced_id,
                    'msg_usr'=>'1',
                    'msg_usuario'=>fake()->name(),
                    'msg_origen'=>fake()->city(),
                    'msg_edad'=>fake()->numberBetween(12,66),
                    'msg_mensaje'=>fake()->realText(200),
                    'msg_date'=>fake()->date(),
                ]);
            }
        #}
    }
}
