<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class autor_url extends Model
{
     #use HasFactory;
	protected $connection='pgsql';
	protected $table = 'autor_url';
	protected $primaryKey = 'aurl_id';
	public $incrementing = true;
	#protected $keyType = 'string';

    protected $fillable = [
        'aurl_id',
        'aurl_act',
        'aurl_del',

        'aurl_edo',
        'aurl_edit',
        'aurl_ciclo',
        'aurl_cautid',
        'aurl_cjarsiglas',
        'aurl_url', ###autorname+lengua
        'aurl_urltxt', #### autorname
        'aurl_key', ###jardin@autorname

        'aurl_lencode',
        'aurl_tradid',

        'aurl_titulo',
        'aurl_tituloorig',
        'aurl_resumen',
        'aurl_resumenorig',
        'aurl_version',
    ];

    ################################################################
    ############# Función que genera automáticamente la columna key
    ############# a partir de concatenar cjarsiglas y urltxt
    protected static function boot() {
        parent::boot();
        static::saving(function ($registro) {
            if ($registro->aurl_cjarsiglas && $registro->aurl_urltxt) {
                $registro->aurl_key = trim($registro->aurl_cjarsiglas . '@' . $registro->aurl_urltxt);
            }
        });
    }

    public function autor():BelongsTo {
        return $this->belongsTo(cat_autores::class, 'aurl_cautid','caut_id');
    }

        public function lengua():BelongsTo {
        return $this->belongsTo(lenguas::class, 'aurl_lencode','len_code');
    }

    public function jardin():BelongsTo {
        return $this->belongsTo(CatJardinesModel::class,'aurl_cjarsiglas','cjar_siglas');
    }
}
