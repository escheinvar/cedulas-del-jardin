<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\cat_tipocedula;

class CatTipocedulaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $events=['sp', 'uso', 'tradición'];

        if (cat_tipocedula::count() == 0 ) {
            // foreach ($events as $event){
                // cat_tipocedula::create(['cced_tipo'=>$event]);
            // }
            cat_tipocedula::create(['cced_tipo'=>'sp']);
            cat_tipocedula::create(['cced_tipo'=>'uso']);
            cat_tipocedula::create(['cced_tipo'=>'tradición']);
        }
    }
}
