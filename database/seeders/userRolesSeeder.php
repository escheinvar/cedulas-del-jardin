<?php

namespace Database\Seeders;

use App\Models\UserRolesModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class userRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $events=[
            [
                'rol_act'=>'1',
                'rol_usrid'=>'1',
                'rol_crolrol'=>'admin',
                'rol_cjarsiglas'=>'todos',
                'rol_describe'=>'Administrador del sistema',
            ],[
                'rol_act'=>'1',
                'rol_usrid'=>'2',
                'rol_crolrol'=>'webmaster',
                'rol_cjarsiglas'=>'todos',
                'rol_describe'=>'Web mastter',
            ],[
                'rol_act'=>'1',
                'rol_usrid'=>'2',
                'rol_crolrol'=>'cedulas',
                'rol_cjarsiglas'=>'todos',
                'rol_tipo1'=>'todas',
                'rol_describe'=>'Administrador de cédulas de un jardín (tipo1)',
            ],[
                'rol_act'=>'1',
                'rol_usrid'=>'2',
                'rol_crolrol'=>'traduce',
                'rol_cjarsiglas'=>'todos',
                'rol_tipo1'=>'todas',
                'rol_tipo2'=>'todas',
                'rol_describe'=>'Traductor de una lengua (tipo2), en un jardin (tipo1)',
            ]
        ];

        if(UserRolesModel::count()=='0'){
            foreach ($events as $event){
                ##### En producción
                UserRolesModel::create($event);
            }
        }

    }
}
