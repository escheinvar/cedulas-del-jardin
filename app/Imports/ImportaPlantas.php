<?php

namespace App\Imports;

use App\Models\ImportaPlantasModel;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ImportaPlantas implements ToModel, WithHeadingRow, WithValidation {
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row) {
        info($row);
        if($row['comunidad'] > 1){$valor='0';}else{$valor='1';}

        return new ImportaPlantasModel([
            'imp_act'=>$valor,
            'imp_camellon'=>$row['camellon'],
            'imp_label'=>$row['label'],
            'imp_sciname'=>$row['sciname'],
            'imp_comname'=>$row['comname'],
            'imp_x'=>$row['x'],
            'imp_y'=>$row['y'],
            'imp_comunidad'=>$row['comunidad'],
            'imp_ramet'=>$row['ramet'],
            'imp_obsejemplar'=>$row['obsejemplar'],
            'imp_obsubica'=>$row['obsubica'],
            'imp_obscaptura'=>$row['obscaptura'],
            'imp_fotolugar'=>$row['fotolugar'],
            'imp_foto1'=>$row['foto1'],
            'imp_foto2'=>$row['foto2'],
            'imp_foto3'=>$row['foto3'],
            'imp_foto4'=>$row['foto4'],
            'imp_foto5'=>$row['foto5'],
            'imp_date'=>$row['date'],
            'imp_flag1'=>$row['flag1'],
            'imp_flag2'=>$row['flag2'],
            'imp_flag3'=>$row['flag3'],
            'imp_flag4'=>$row['flag4'],
            'imp_flag5'=>$row['flag5'],
        ]);


    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function rules(): array
    {
        return [
            'camellon' => 'required',
            'label' => 'required|unique:pl_plantas,pl_idcolecta|unique:pl_import,imp_label',
            'x' => 'required|numeric',
            'y' => 'required|numeric',
        ];
    }

}
