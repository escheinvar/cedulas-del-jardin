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

        'ali_urlid',
        'ali_cjarsiglas',
        'ali_urltxt',
        'ali_urlurl',

        'ali_calitipo',
        'ali_txt',
        'ali_txt_tr',
        'ali_lengua',
    ];

    ################################################################
    ############# Función que genera automáticamente la columna key
    ############# a partir de concatenar cjarsiglas y urltxt
    protected static function boot() {
        parent::boot();
        static::saving(function ($registro) {
            if ($registro->ali_cjarsiglas && $registro->ali_urltxt) {
                $registro->ali_key = trim($registro->ali_cjarsiglas . '@' . $registro->ali_urltxt);
            }
        });
    }

    public function jardin():BelongsTo{
        return $this->belongsTo(CatJardinesModel::class,'cjar_siglas','ali_cjarsiglas');
    }

    public function cedula():BelongsTo{
        return $this->belongsTo(cedulas_url::class,'url_url','ali_urlurl');
    }
}
