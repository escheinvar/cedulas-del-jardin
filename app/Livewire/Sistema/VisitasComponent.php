<?php

namespace App\Livewire\Sistema;

use App\Models\SistVisitasModel;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Component;



// #[Layout('components.layouts.SistemaBase')]
class VisitasComponent extends Component
{
    public $desde, $hasta;
    public function mount(){
        #$this->desde="2025-04-15";
        $this->desde=date('Y-m-d');
        $this->hasta=date('Y-m-d');
    }

    public function render(){
        $visitas=SistVisitasModel::groupBy('vis_url2')
            ->select('vis_url2', DB::raw('count (vis_url2) as cant'))
            ->where('created_at', '>=', $this->desde." 00:00:00.001")
            ->where('created_at', '<=', $this->hasta." 23:59:59.999")
            ->orderBy('cant','desc')
            ->get();

        $Ips=SistVisitasModel::groupBy('vis_url2','vis_ip','vis_pais','vis_regionname','vis_ciudad','region')
            ->select('vis_url2', 'vis_ip', DB::raw('count (vis_ip) as cant'), 'vis_pais','vis_regionname',DB::raw("CONCAT(vis_pais,'-',vis_regionname) AS region"))
            ->where('created_at', '>=', $this->desde." 00:00:00.001")
            ->where('created_at', '<=', $this->hasta." 23:59:59.999")
            ->orderBy('vis_pais','asc')
            ->get();


        return view('livewire.sistema.visitas-component',[
            'visitas'=>$visitas,
            'Ips'=>$Ips,
        ]);
    }
}
