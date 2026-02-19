<?php

namespace App\Exports;

use App\Models\ImportaPlantasModel;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class ExportaPlantas implements FromCollection,  WithHeadings {
    public function headings(): array {
        return [
            'label',
            'camellon',
            'x',
            'y',
            'comunidad',
            'sciname',
            'comname',
            'ramet',
            'obsejemplar',
            'obsubica',
            'obscaptura',
            'fotolugar',
            'foto1',
            'foto2',
            'foto3',
            'foto4',
            'foto5',
            'date',
            'flag1',
            'flag2',
            'flag3',
            'flag4',
            'flag5',
        ];
    }


    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return DB::table('pl_import')->select(
            'imp_label',
            'imp_camellon',
            'imp_x',
            'imp_y',
            'imp_comunidad',
            'imp_sciname',
            'imp_comname',
            'imp_ramet',
            'imp_obsejemplar',
            'imp_obsubica',
            'imp_obscaptura',
            'imp_fotolugar',
            'imp_foto1',
            'imp_foto2',
            'imp_foto3',
            'imp_foto4',
            'imp_foto5',
            'imp_date',
            'imp_flag1',
            'imp_flag2',
            'imp_flag3',
            'imp_flag4',
            'imp_flag5',
        )->get();
    }
}
