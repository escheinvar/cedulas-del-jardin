<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\cat_tipocedula;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call([
            #### Genera catálogos
            userSeeder::class,              ##### real 2 usrs iniciales
            CatRolesSeeder::class,          ##### real catalogo sistema
            userRolesSeeder::class,         ##### real de los 2 usrs iniciales
            CatJardinesCampusSeeder::class, ##### real catálogo del sistema
            CatLenguasSeeder::class,        ##### real catálogo del sistema
            CatLenguasInaliSeeder::class,   ##### real catálogo del sistema
            CatEntidadesSeeder::class,      ##### real catálogo del sistema
            Nom054semarnatSeeder::class,    ##### real catálogo del sistema
            #BuzonSeeder::class,            ##### datos inventados
            LenguasSeeder::class,           ##### real lenguas iniciales
            cat_imgSeeder::class,           ##### real catálogo del sistema
            CatTipocedulaSeeder::class,     ##### real catálogo del sistema
            #CatAutoresSeeder::class,       ##### datos inventados
            #CedulaUrlSeeder::class,        ##### datos inventados
            #CatUsosSeeder::class,          ##### datos inventados
            CedCatalogos::class,            ##### real catálogo del sistema
            CatRedesSeeder::class,          ##### real catálogo del sistemaS
        ]);
    }
}
