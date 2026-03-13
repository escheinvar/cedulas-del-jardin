<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ced_usos extends Model
{
    #use HasFactory;
	protected $connection='pgsql';
	protected $table = 'ced_uso';
	protected $primaryKey = 'uso_id';
	public $incrementing = true;
	#protected $keyType = 'string';

    protected $fillable = [
        'uso_id',
        'uso_act',
        'uso_del',
        'uso_cjarsiglas',
        'uso_urlurl',

        'uso_categoria',
        'uso_parte',
        'uso_uso',
    ];

    public function jardin():BelongsTo{
        return $this->belongsTo(CatJardinesModel::class,'cjar_siglas','uso_cjarsiglas');
    }

    public function cedula():BelongsTo{
        return $this->belongsTo(cedulas_url::class,'url_url','uso_urlurl');
    }
}
