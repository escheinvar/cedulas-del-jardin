<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class cedulas_url extends Model
{
    #use HasFactory;
	protected $connection='pgsql';
	protected $table = 'cedula_url';
	protected $primaryKey = 'url_id';
	public $incrementing = true;
	#protected $keyType = 'string';

    protected $fillable = [
        'url_id',
        'url_act',
        'url_del',

        'url_edo',
        'url_ciclo',
        'url_ccedtipo',
        'url_ccedtipo',

        'url_cjarsiglas',
        'url_cjarsiglas',
        'url_urltxt',
        'url_url',
        'url_lencode',
        'url_lencode',
        'url_tradid',

        'url_titulo',
        'url_tituloorig',
        'url_resumen',
        'url_resumenorig',
        'url_cita',
        'url_anio',
        // 'url_editor',
        'url_vesion',
        'url_doi',

    ];

    public function jardin(): BelongsTo {
        return $this->belongsTo(CatJardinesModel::class,'url_cjarsiglas','cjar_siglas');
    }

    public function lenguas(): BelongsTo {
        return $this->belongsTo(lenguas::class, 'url_lencode','len_code');
    }
}
