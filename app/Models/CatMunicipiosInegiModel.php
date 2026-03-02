<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatMunicipiosInegiModel extends Model
{
    use HasFactory;
	protected $connection='pgsql';
	protected $table = 'cat_municipios_inegi';
	protected $primaryKey = 'cmun_id';
	public $incrementing = true;
	#protected $keyType = 'string';

    protected $fillable = [
        'cmun_cedoid',
        'cmun_edoname',
        'cmun_mpioid',
        'cmun_mpioname',
        'cmun_cabeceraid',
        'cmun_cabeceraname',
    ];
}
