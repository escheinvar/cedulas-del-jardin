<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ced_externos extends Model
{
    #use HasFactory;
	protected $connection='pgsql';
	protected $table = 'ced_externos';
	protected $primaryKey = 'ext_id';
	public $incrementing = true;
	#protected $keyType = 'string';

    protected $fillable = [
        'ext_id',
        'ext_act',
        'ext_del',

        'ext_jardin',
        'ext_urltxt',
        'ext_redid',

        'ext_titulo',
        'ext_fuentename',
        'ext_fuenteurl',
        'ext_fuenteicon',

        'ext_autorname',
        'ext_autorurl',
        'ext_explica',
        'ext_url',
        'ext_caratula',
        'ext_fecha',
        'ext_ultverific',
    ];

    public function red():BelongsTo{
        return $this->belongsTo(cat_redes::class,'ext_redid','red_id');
    }

}
