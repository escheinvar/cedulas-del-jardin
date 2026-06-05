<?php

namespace App\Livewire\Recursos;

use App\Models\jue_memoria;
use App\Models\juegos;
use Livewire\Component;

class MemoramaComponent extends Component
{
    public $edit;
    public $nombres, $NombreJuego, $turno, $par;
    public $NvoJugador, $baraja, $granAyuda;

    public function mount(){
        $this->nombres=[];
        $this->NombreJuego='0';
        $this->baraja=collect();

        $auts=['admin','webmaster'];
        if(array_intersect($auts,session('rol'))){$this->granAyuda=TRUE;}else{$this->granAyuda=FALSE;}

        // $this->nombres=[
        //     ['name'=>'Enrique','pt'=>'0'],
        //     ['name'=>'Niza','pt'=>'0'],
        //     ['name'=>'Camilo','pt'=>'0'],
        //     ['name'=>'Luciana','pt'=>'0'],
        //     ['name'=>'Chia','pt'=>'0'],
        //     ['name'=>'Mandarina','pt'=>'0'],
        // ];
    }

    public function AgregaJugador(){
        if($this->NvoJugador!= ''){
            $this->nombres[]=['name'=>$this->NvoJugador, 'pt'=>'0'];
        }
        $this->NvoJugador='';
    }

    public function turnar(){
        $max=count($this->nombres)-1;
        if($this->turno < $max){
            $this->turno=$this->turno + 1;
        }else{
            $this->turno='0';
        }
        // $this->par=[];
    }

    public function SeleccionaJuego($jue){
        ##### Si no hay nombre, asigna uno
        if(count($this->nombres) < '1'){
            $this->nombres[]=['name'=>'Anónimo', 'pt'=>'0'];
        }

        ##### Asigna nombre de juego
        $this->NombreJuego=$jue;

        ##### Selecciona baraja
        $this->baraja=jue_memoria::where('mem_name',$jue)
            ->where('mem_act','1')
            ->where('mem_del','0')
            ->inRandomOrder()
            ->get();

        #### Inicia turno
        $this->turno='0';
        $this->par=[];
    }


    public function TurnoDeJuego($id){
        $audio=jue_memoria::where('mem_id',$id)->where('mem_aud','!=','')->count();

        ##### Resuelve tanda previa (desaparece o regresa cartas)
        if(count($this->par)=='2'){
            ##### Revisa cartas
            $carta1=jue_memoria::where('mem_id',$this->par['0'])->value('mem_par');
            $carta2=jue_memoria::where('mem_id',$this->par['1'])->value('mem_par');
            if($carta1 == $carta2){
                $this->dispatch('GanaCartas', id1:$this->par['0'], id2:$this->par['1']);
            }else{
                $this->dispatch('CierraCartas', id1:$this->par['0'], id2:$this->par['1']);
            }
            $this->par=[];
        }

        ##### Si es la primer carta:
        if(count($this->par)=='0'){
            ##### Destapa la carta
            $this->dispatch('AbreCarta',id:$id);
            if($audio > '0'){$this->dispatch('EjecutaAudio',id:$id);}
            ##### guarda valor
            $this->par['0']=$id;

        ##### Si es la segunda carta:
        }elseif(count($this->par)=='1' and ($id != $this->par['0']) ){
            ##### Destapa la carta
            $this->dispatch('AbreCarta',id:$id);
            if($audio > '0'){$this->dispatch('EjecutaAudio',id:$id);}
            #### Guarda valor par
            $this->par['1']=$id;

            ##### Revisa cartas
            $carta1=jue_memoria::where('mem_id',$this->par['0'])->value('mem_par');
            $carta2=jue_memoria::where('mem_id',$this->par['1'])->value('mem_par');

            #### En caso de que gana:
            if($carta1 == $carta2){
                $this->dispatch('AvisaGana',id1:$this->par['0'], id2:$this->par['1']);
                // $this->dispatch('GanaCartas', id1:$this->par['0'], id2:$this->par['1']);
                $this->nombres[$this->turno]['pt']=$this->nombres[$this->turno]['pt']+1;

            ##### En caso de que pierde:
            }else{
                // $this->dispatch('CierraCartas', id1:$this->par['0'], id2:$this->par['1']);
                $this->turnar();
                // $this->dispatch('AvisoExitoMemoria',msj:'Turno de '.$this->nombres[$this->turno]['name']);
            }
            // $this->par=[];
        }

    }

    public function render() {
        ##### Establece permiso
        $this->edit='0';
        if(session('rol')){
            ##### Verifica permisos
            $auts=['admin','webmaster'];
            if(array_intersect($auts,session('rol'))){
                $this->edit='1';
            }
        }

        $NombreJuegos=juegos::where('jue_act','1')
            ->where('jue_del','0')
            ->with('cartas')
            ->get();

        return view('livewire.recursos.memorama-component',[
            'NombreJuegos'=> $NombreJuegos,
        ]);
    }
}
