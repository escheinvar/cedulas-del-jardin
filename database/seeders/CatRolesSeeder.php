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
            ['crol_mod'=>'base', 'crol_rol'=>'admin',           'crol_describe'=>'Persona adscrita a un jardín y que administra sus usuarios, roles y cédulas', 'crol_notas'=>''],
            ['crol_mod'=>'base', 'crol_rol'=>'webmaster',       'crol_describe'=>'Persona adscrita a un jardín que puede editar la página del jardín y los datos de autores', 'crol_notas'=>''],

            ['crol_mod'=>'cedulas', 'crol_rol'=>'autor',        'crol_describe'=>'Persona autora de una cédula.', 'crol_notas'=>'en campo tipo1 se puede usar "todas" para dar acceso a todos los jardines'],
            ['crol_mod'=>'cedulas', 'crol_rol'=>'traductor',    'crol_describe'=>'Persona traductora de una lengua', 'crol_notas'=>'un permiso es solo para una lengua en un jardín. (no existe opción "todos")'],
            ['crol_mod'=>'cedulas', 'crol_rol'=>'editor',       'crol_describe'=>'Persona que edita y autoriza la publicación de una cédula o traducción', 'crol_notas'=>'un permiso es solo para una lengua en un jardín. (no existe opción "todos")'],
            ['crol_mod'=>'base', 'crol_rol'=>'usr',             'crol_describe'=>'Usuario general del sistema', 'crol_notas'=>''],
        ];

        if (CatRolesModel::count() == 0 ) {
            foreach ($events as $event){
                CatRolesModel::create($event);
            }
        }
    }
}
