<?php

namespace App\Models;

use App\Models\CatJardinesModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ced_alias extends Model
{
    #use HasFactory;
	protected $connection='pgsql';
	protected $table = 'ced_alias';
	protected $primaryKey = 'ali_id';
	public $incrementing = true;
	#protected $keyType = 'string';

    protected $fillable = [
        'ali_id',
        'ali_act',
        'ali_del',
        'ali_cjarsiglas',
        'ali_urlurl',

        'ali_calitipo',
        'ali_txt',
        'ali_lengua',
    ];

    public function jardin():BelongsTo{
        return $this->belongsTo(CatJardinesModel::class,'cjar_siglas','ali_cjarsiglas');
    }

    public function cedula():BelongsTo{
        return $this->belongsTo(cedulas_url::class,'url_url','ali_urlurl');
    }
}
