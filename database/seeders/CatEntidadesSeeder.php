<?php

namespace Database\Seeders;

use App\Models\CatEntidadesInegiModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CatEntidadesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $events=[
            ['cedo_nombre'=>'Aguascalientes','cedo_abrevia'=>'Ags.'],
            ['cedo_nombre'=>'Baja California','cedo_abrevia'=>'BC'],
            ['cedo_nombre'=>'Baja California Sur','cedo_abrevia'=>'BCS'],
            ['cedo_nombre'=>'Campeche','cedo_abrevia'=>'Camp.'],
            ['cedo_nombre'=>'Coahuila de Zaragoza','cedo_abrevia'=>'Coah.'],
            ['cedo_nombre'=>'Colima','cedo_abrevia'=>'Col.'],
            ['cedo_nombre'=>'Chiapas','cedo_abrevia'=>'Chis.'],
            ['cedo_nombre'=>'Chihuahua','cedo_abrevia'=>'Chih.'],
            ['cedo_nombre'=>'Ciudad de México','cedo_abrevia'=>'CDMX'],
            ['cedo_nombre'=>'Durango','cedo_abrevia'=>'Dgo.'],
            ['cedo_nombre'=>'Guanajuato','cedo_abrevia'=>'Gto.'],
            ['cedo_nombre'=>'Guerrero','cedo_abrevia'=>'Gro.'],
            ['cedo_nombre'=>'Hidalgo','cedo_abrevia'=>'Hgo.'],
            ['cedo_nombre'=>'Jalisco','cedo_abrevia'=>'Jal.'],
            ['cedo_nombre'=>'México','cedo_abrevia'=>'Mex.'],
            ['cedo_nombre'=>'Michoacán de Ocampo','cedo_abrevia'=>'Mich.'],
            ['cedo_nombre'=>'Morelos','cedo_abrevia'=>'Mor.'],
            ['cedo_nombre'=>'Nayarit','cedo_abrevia'=>'Nay.'],
            ['cedo_nombre'=>'Nuevo León','cedo_abrevia'=>'NL'],
            ['cedo_nombre'=>'Oaxaca','cedo_abrevia'=>'Oax.'],
            ['cedo_nombre'=>'Puebla','cedo_abrevia'=>'Pue.'],
            ['cedo_nombre'=>'Querétaro','cedo_abrevia'=>'Qro.'],
            ['cedo_nombre'=>'Quintana Roo','cedo_abrevia'=>'Q. Roo'],
            ['cedo_nombre'=>'San Luis Potosí','cedo_abrevia'=>'SLP'],
            ['cedo_nombre'=>'Sinaloa','cedo_abrevia'=>'Sin.'],
            ['cedo_nombre'=>'Sonora','cedo_abrevia'=>'Son.'],
            ['cedo_nombre'=>'Tabasco','cedo_abrevia'=>'Tab.'],
            ['cedo_nombre'=>'Tamaulipas','cedo_abrevia'=>'Tamps.'],
            ['cedo_nombre'=>'Tlaxcala','cedo_abrevia'=>'Tlax.'],
            ['cedo_nombre'=>'Veracruz de Ignacio de la Llave','cedo_abrevia'=>'Ver.'],
            ['cedo_nombre'=>'Yucatán','cedo_abrevia'=>'Yuc.'],
            ['cedo_nombre'=>'Zacatecas','cedo_abrevia'=>'Zac.']
        ];
        if(CatEntidadesInegiModel::count()=='0'){
            foreach ($events as $event){
                CatEntidadesInegiModel::create($event);
            }
        }
    }
}
