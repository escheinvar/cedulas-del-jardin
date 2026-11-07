<?php

namespace App\Livewire\Web;

use App\Models\CatJardinesModel;
use Database\Seeders\CatJardinesCampusSeeder;
use Livewire\Component;

class SistJardinesController extends Component
{
    public function render(){
        $jardines=CatJardinesModel::with('cedulas')
            ->with('autores')
            ->with('lista')
            ->get();

        return view('livewire.web.sist-jardines-controller',[
            'jardines'=>$jardines,
        ]);
    }
}
