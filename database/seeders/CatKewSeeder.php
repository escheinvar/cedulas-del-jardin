<?php

namespace Database\Seeders;

use App\Models\CatKewModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CatKewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // // 1. Split by new line. Use the PHP_EOL constant for cross-platform compatibility.
        // $lines = explode(PHP_EOL, 'wcvp_taxon_kew.csv');

        // // 2. Extract the header and convert it into a Laravel collection.
        // $header = collect(str_getcsv(array_shift($lines)));

        // // 3. Convert the rows into a Laravel collection.
        // $rows = collect($lines);

        // // 4. Map through the rows and combine them with the header to produce the final collection.
        // $data = $rows->map(fn($row) => $header->combine(str_getcsv($row)));

        // foreach ($data as $d){
        //     CatKewModel::create($d);
        // }  
        
       
    }
}
