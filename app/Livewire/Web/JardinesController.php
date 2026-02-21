<?php

namespace App\Livewire\Web;

use App\Models\CatJardinesModel;
use Database\Seeders\CatJardinesCampusSeeder;
use Livewire\Component;

class JardinesController extends Component
{
    public function render(){
        $jardines=CatJardinesModel::get();

        return view('livewire.web.jardines-controller',[
            'jardines'=>$jardines,
        ]);
    }
}
