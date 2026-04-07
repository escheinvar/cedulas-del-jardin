<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class autor_txt extends Model
{
     #use HasFactory;
	protected $connection='pgsql';
	protected $table = 'autor_txt';
	protected $primaryKey = 'autxt_id';
	public $incrementing = true;
	#protected $keyType = 'string';

    protected $fillable = [
        'autxt_id',
        'autxt_cjarsiglas',
        'autxt_cautid',
        'autxt_cauturl',

        'autxt_act',
        'autxt_del',
        'autxt_tipo',
        'autxt_orden',

        'autxt_txt',
        'autxt_txtoriginal',
        'autxt_audio',
        'autxt_version',
    ];

    ################################################################
    ############# Función que genera automáticamente la columna key
    ############# a partir de concatenar cjarsiglas y urltxt
    protected static function boot() {
        parent::boot();
        static::saving(function ($registro) {
            if ($registro->autxt_cjarsiglas && $registro->autxt_cauturl) {
                $registro->autxt_key = trim($registro->autxt_cjarsiglas . '@' . $registro->autxt_cauturl);
            }
        });
    }

    public function url():BelongsTo {
        return $this->belongsTo(cat_autores::class, 'autxt_cautid','caut_id');
    }

    public function cedulas():HasMany{
        return $this->hasMany(ced_autores::class, 'aut_cautid','autxt_cautid')
            ->where('aut_act','1')->where('aut_del','0');
    }

    public function jardin():BelongsTo {
        return $this->belongsTo(CatJardinesModel::class,'autxt_cjarsiglas','cjar_siglas');
    }
}
