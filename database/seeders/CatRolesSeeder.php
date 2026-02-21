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
            ['crol_mod'=>'base', 'crol_rol'=>'admin',        'crol_describe'=>'Persona adscrita a un jardín y que administra sus usuarios, roles y cédulas', 'crol_notas'=>''],
            ['crol_mod'=>'base', 'crol_rol'=>'webmaster',    'crol_describe'=>'Persona adscrita a un jardín que puede editar la página del jardín y los datos de autores', 'crol_notas'=>''],

            ['crol_mod'=>'cedulas', 'crol_rol'=>'autor',     'crol_describe'=>'Administrador de cédulas de un jardín (tipo1=jardin) o en todos los jardines (tipo1=todos).', 'crol_notas'=>'en campo tipo1 se puede usar "todas" para dar acceso a todos los jardines'],
            ['crol_mod'=>'cedulas', 'crol_rol'=>'traduce',   'crol_describe'=>'Traductor de una lengua (tipo2), en un jardin (tipo1)', 'crol_notas'=>'un permiso es solo para una lengua en un jardín. (no existe opción "todos")'],
            ['crol_mod'=>'base', 'crol_rol'=>'usr',          'crol_describe'=>'Usuario general del sistema', 'crol_notas'=>''],
            ];

        if (CatRolesModel::count() == 0 ) {
            foreach ($events as $event){
                CatRolesModel::create($event);
            }
        }
    }
}
