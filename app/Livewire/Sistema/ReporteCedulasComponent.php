<?php

namespace App\Livewire\Sistema;

use App\Models\lenguas;
use App\Models\cedulas_url;
use Livewire\Component;

class ReporteCedulasComponent extends Component
{
    public function render() {
        $orig = cedulas_url::where('url_tradid','0')
            ->where('url_act','1')
            ->where('url_del','0')
            ->orderBy('url_cjarsiglas')
            ->orderBy('url_id')
            ->get();
        $trad = cedulas_url::where('url_tradid','>','0')
            ->where('url_act','1')
            ->where('url_del','0')
            ->orderBy('url_cjarsiglas')
            ->orderBy('url_id')
            ->get();

        $lenguas= $trad->unique('url_lencode')
            ->pluck('url_lencode')
            ->toArray();
        $len = lenguas::whereIn('len_code',$lenguas)
            ->get();

        return view('livewire.sistema.reporte-cedulas-component',[
            'orig' => $orig,
            'trad' => $trad,
            'len' => $len
        ]);
    }
}
