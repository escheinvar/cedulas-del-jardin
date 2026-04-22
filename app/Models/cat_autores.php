<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class cat_autores extends Model
{
    //  use HasFactory;
	protected $connection='pgsql';
	protected $table = 'cat_autores';
	protected $primaryKey = 'caut_id';
	public $incrementing = true;
	#protected $keyType = 'string';

    protected $fillable = [
        'caut_id',
        'caut_act',
        'caut_del',
        'caut_edit',
        // 'caut_cjarsiglas',
        'caut_nombre',
        'caut_apellido1',
        'caut_apellido2',
        'caut_nombreautor',
        'caut_url',
        'caut_correo',
        'caut_institu',
        'caut_comunidad',
        'caut_tel',
        'caut_usrid',
        // 'caut_lenguas',
        // 'caut_web',
        'caut_mailpublic',
        'caut_orcid',
        'caut_scopus',
        'caut_researchid',
        'caut_isni',
        'caut_otrosid',
        // 'caut_img',
    ];

    public function cedulas():HasMany{
        return $this->hasMany(ced_autores::class, 'aut_cautid','caut_id')
            ->join('cedula_url','url_id','=','aut_urlid')
            ->where('aut_act','1')->where('aut_del','0')
            ->where('url_act','1')->where('url_del','0');
    }

    public function urlautor():HasMany{
        return $this->hasMany(autor_url::class, 'aurl_cautid','caut_id');
    }

}
