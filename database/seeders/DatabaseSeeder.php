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
            userSeeder::class,
            CatRolesSeeder::class,
            userRolesSeeder::class,
            CatJardinesCampusSeeder::class,
            CatLenguasSeeder::class,
            CatLenguasInaliSeeder::class,
            CatEntidadesSeeder::class,
            #SpUrlSeeder::class,
            #SpUrlCedulaSeeder::class,
            #SpCedulaSeeder::class,
            #SpFotosSeeder::class,
            #Nom054semarnatSeeder::class,
            BuzonSeeder::class,
            LenguasSeeder::class,
            cat_imgSeeder::class,
            #### Cédulas:
            CatTipocedulaSeeder::class,
            CatAutoresSeeder::class,
            CedulaUrlSeeder::class,
            CatUsosSeeder::class,
            CedCatalogos::class,
        ]);
    }
}
