<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class userSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ##### En producción
        if(User::count()=='0'){
            User::firstOrCreate(['email'=>'admin@mail.com'],[
                'id'=>'1',
                'email'=>'admin@mail.com',
                'nombre'=>'Enrique',
                'apellido'=>'Scheinvar',
                'usrname'=>'escheinvar',
                'nace'=>'1977-07-22',
                'cinsid'=>'1',
                'avatar'=>null,
                'password'=>Hash::make('admin'),
                'avatar'=>'/avatar/usr2.png'
            ]);
        }
    }
}
