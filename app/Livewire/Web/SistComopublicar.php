<?php

namespace App\Livewire\Web;

use Livewire\Component;

class SistComopublicar extends Component
{
    public $paso1,$paso2,$paso3,$paso4,$paso5,$paso6,$paso7,$paso8,$paso9,$paso10;

    public function mount()    {
        $this->paso1='0';
        $this->paso2='0';
        $this->paso3='0';
        $this->paso4='0';
        $this->paso5='0';
        $this->paso6='0';
        $this->paso7='0';
        $this->paso8='0';
        $this->paso9='0';
        $this->paso10='0';
    }

    public function VerONoVer($var){
        if($this->$var=='0'){
            $this->$var='1';
        }else{
            $this->$var='0';
        }
    }


    public function render()    {
        return view('livewire.web.sist-comopublicar');
    }
}
