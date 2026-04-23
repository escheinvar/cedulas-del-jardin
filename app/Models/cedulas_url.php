<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
        'url_edit',
        'url_ciclo',
        'url_ccedtipo',

        'url_cjarsiglas',
        'url_urltxt',
        'url_url',
        'url_lencode',
        'url_tradid',

        'url_titulo',
        'url_tituloorig',
        'url_resumen',
        'url_resumenorig',
        'url_cita',
        'url_cita_aut',
        'url_cita_trad',
        'url_anio',
        // 'url_editor',
        'url_version',
        'url_doi',

    ];
    ################################################################
    ############# Función que genera automáticamente la columna key
    ############# a partir de concatenar cjarsiglas y urltxt
    protected static function boot() {
        parent::boot();
        static::saving(function ($registro) {
            if ($registro->url_cjarsiglas && $registro->url_urltxt) {
                $registro->url_key = trim($registro->url_cjarsiglas . '@' . $registro->url_urltxt);
            }
        });
    }



    public function jardin(): BelongsTo {
        return $this->belongsTo(CatJardinesModel::class,'url_cjarsiglas','cjar_siglas');
    }

    public function lenguas(): BelongsTo {
        return $this->belongsTo(lenguas::class, 'url_lencode','len_code');
    }

    public function autores():HasMany {
        return $this->HasMany(ced_autores::class,'aut_urlid','url_id')
            ->where('aut_tipo','Autor')
            ->where('aut_act','1')
            ->where('aut_del','0')
            ->leftJoin('cat_autores','caut_id','=','aut_cautid');
    }

    public function editores():HasMany {
        return $this->HasMany(ced_autores::class,'aut_urlid','url_id')
            ->where('aut_tipo','Editor')
            ->where('aut_act','1')
            ->where('aut_del','0')
            ->leftJoin('cat_autores','caut_id','=','aut_cautid');
    }

    public function traductores():HasMany {
        return $this->HasMany(ced_autores::class,'aut_urlid','url_id')
            ->where('aut_tipo','Traductor')
            ->where('aut_act','1')
            ->where('aut_del','0')
            ->leftJoin('cat_autores','caut_id','=','aut_cautid');
    }

    public function ubicaciones():HasMany {
        return $this->HasMany(ced_ubica::class, 'ubi_urlid','url_id')
            ->where('ubi_act','1')
            ->where('ubi_del','0')
            ->orderBy('ubi_ubicacion_tr');
    }

    public function alias():HasMany {
        return $this->HasMany(ced_alias::class, 'ali_urlid','url_id')
            ->where('ali_act','1')
            ->where('ali_del','0')
            ->orderBy('ali_txt_tr');
    }

    public function especies():HasMany{
        return $this->HasMany(ced_sp::class, 'sp_key','url_key')
            ->where('sp_act','1')
            ->where('sp_del','0');
    }

    public function usos():HasMany{
        return $this->HasMany(ced_usos::class, 'uso_key','url_key')
            ->join('ced_sp', 'sp_id','uso_spid')
            ->where('uso_act','1')
            ->where('uso_del','0')
            ->where('sp_act','1')
            ->where('sp_del','0');
    }

    public function versiones():HasMany{
        return $this->HasMany(ced_version::class, 'ver_cedid','url_id')
            ->where('ver_act','1')
            ->where('ver_del','0');
    }

    public function objetos():HasMany{
        return $this->HasMany(Imagenes::class, 'img_key','url_key')
            ->where('img_act','1')
            ->where('img_del','0');
    }
}
