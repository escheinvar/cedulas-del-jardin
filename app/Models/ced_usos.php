<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ced_usos extends Model
{
    #use HasFactory;
	protected $connection='pgsql';
	protected $table = 'ced_usos';
	protected $primaryKey = 'uso_id';
	public $incrementing = true;
	#protected $keyType = 'string';

    protected $fillable = [
        'uso_id',
        'uso_act',
        'uso_del',
        'uso_spid',
        'uso_spname',
        'uso_cjarsiglas',
        'uso_urltxt',

        'uso_categoria',
        'uso_partes',
        'uso_uso',
        'uso_describe',
    ];

    public function especie():BelongsTo{
        return $this->belongsTo(ced_sp::class,'sp_id','uso_spid');
    }

    public function jardin():BelongsTo{
        return $this->belongsTo(CatJardinesModel::class,'cjar_siglas','uso_cjarsiglas');
    }

    public function cedula():BelongsTo{
        return $this->belongsTo(cedulas_url::class,'url_url','uso_urlurl');
    }
}
