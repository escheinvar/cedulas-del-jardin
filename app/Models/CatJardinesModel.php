<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CatJardinesModel extends Model
{
    use HasFactory;
	protected $connection='pgsql';
	protected $table = 'cat_jardines';
	protected $primaryKey = 'cjar_id';
	public $incrementing = true;
	#protected $keyType = 'string';

    protected $fillable = [
        'cjar_name',
        'cjar_nombre',
        'cjar_siglas',
        'cjar_act',
        'cjar_del',
        'cjar_tipo',
        'cjar_direccion',
        'cjar_tel',
        'cjar_mail',
        'cjar_edo',
        'cjar_logo',

        'cjar_face',
        'cjar_insta',
        'cjar_youtube',
        'cjar_www',
        'cjar_red1',
        'cjar_red2',
        'cjar_red3',
        'cjar_ubica',
    ];
    //  public function url():BelongsTo {
    //     return $this->belongsTo(jardin_url::class,'jar_urljid','urlj_id');
    // }
    ##### Vincula a cédulas
    public function cedulas():HasMany{
        return $this->HasMany(cedulas_url::class, 'url_cjarsiglas','cjar_siglas')
            ->where('url_act','1')
            ->where('url_del','0');
    }

    ##### Vincula a autores
    public function autores():HasMany{
        return $this->HasMany(ced_autores::class, 'aut_cjarsiglas','cjar_siglas')
            ->where('aut_act','1')
            ->where('aut_del','0');
    }

    public function lista():HasMany{
        return $this->HasMany(lista::class, 'lst_cjarsiglas','cjar_siglas')
            ->where('lst_act','1')
            ->where('lst_del','0');
    }
}
