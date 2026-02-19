<?php

namespace Database\Seeders;

use App\Models\CatRolesModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CatRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $events=[
            ['crol_mod'=>'base', 'crol_rol'=>'admin',        'crol_describe'=>'Administrador General del sistema', 'crol_notas'=>''],
            ['crol_mod'=>'base', 'crol_rol'=>'webmaster',    'crol_describe'=>'Web master', 'crol_notas'=>''],
            ['crol_mod'=>'base', 'crol_rol'=>'usr',          'crol_describe'=>'Usuario general del sistema', 'crol_notas'=>''],
            ['crol_mod'=>'cedulas', 'crol_rol'=>'cedulas',   'crol_describe'=>'Administrador de cédulas de un jardín (tipo1=jardin) o en todos los jardines (tipo1=todos).', 'crol_notas'=>'en campo tipo1 se puede usar "todas" para dar acceso a todos los jardines'],
            ['crol_mod'=>'cedulas', 'crol_rol'=>'traduce',   'crol_describe'=>'Traductor de una lengua (tipo2), en un jardin (tipo1)', 'crol_notas'=>'un permiso es solo para una lengua en un jardín. (no existe opción "todos")'],
        ];

        if (CatRolesModel::count() == 0 ) {
            foreach ($events as $event){
                CatRolesModel::create($event);
            }
        }
    }
}
