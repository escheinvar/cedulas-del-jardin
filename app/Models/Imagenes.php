<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Imagenes extends Model
{
     #use HasFactory;
	protected $connection='pgsql';
	protected $table = 'imagenes';
	protected $primaryKey = 'img_id';
	public $incrementing = true;
	#protected $keyType = 'string';

    protected $fillable = [
        'img_id',
        'img_act',
        'img_del',

        'img_cimgmodulo',
        'img_cimgtipo',
        'img_cjarsiglas',

        'img_urlid',
        'img_urlurl',
        'img_key',
        'img_urltxt',
        'img_lencode',

        'img_file',
        'img_web',
        'img_html',

        'img_tipo',
        'img_size',
        'img_resolu',
        'img_titulo',
        'img_tituloact',
        'img_pie',
        'img_explica',
        'img_autor',
        'img_fecha',
        'img_ubica',
        'img_lonx',
        'img_laty',
        'img_usrid',
    ];

    ################################################################
    ############# Función que genera automáticamente la columna key
    ############# a partir de concatenar cjarsiglas y urltxt
    protected static function boot() {
        parent::boot();
        static::saving(function ($registro) {
            if ($registro->img_cjarsiglas && $registro->img_urltxt) {
                $registro->img_key = trim($registro->img_cjarsiglas . '@' . $registro->img_urltxt);
            }
        });
    }


    public function alias():HasMany{
        return $this->hasMany(alias_img::class,'aimg_imgid')
            ->where('aimg_act','1')->where('aimg_del','0');
    }

}
