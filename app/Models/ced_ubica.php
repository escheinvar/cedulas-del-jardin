<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ced_ubica extends Model
{
    #use HasFactory;
	protected $connection='pgsql';
	protected $table = 'ced_ubica';
	protected $primaryKey = 'ubi_id';
	public $incrementing = true;
	#protected $keyType = 'string';

    protected $fillable = [
        'ubi_id',
        'ubi_act',
        'ubi_del',
        'ubi_cjarsiglas',
        'ubi_urltxt',

        'ubi_tipo',
        'ubi_edo',
        'ubi_mpio',
        'ubi_localidad',
        'ubi_paraje',
        'ubi_ubicacion',
    ];

    public function jardin():BelongsTo{
        return $this->belongsTo(CatJardinesModel::class,'cjar_siglas','ubi_cjarsiglas');
    }

    public function cedula():BelongsTo{
        return $this->belongsTo(cedulas_url::class,'url_url','ubi_urlurl');
    }
}
