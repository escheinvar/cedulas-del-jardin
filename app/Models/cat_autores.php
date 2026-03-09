<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
        'caut_cjarsiglas',
        'caut_nombre',
        'caut_apellido1',
        'caut_apellido2',
        'caut_nombreautor',
        'caut_url',
        'caut_correo',
        'caut_institu',
        'caut_usrid',
        'caut_lenguas',
        'caut_web',
        'caut_mailpublic',
        'caut_orcid',
        'caut_img',
    ];

    public function jardin():BelongsTo{
        return $this->belongsTo(CatJardinesModel::class,'caut_cjarsiglas','cjar_siglas');
    }
}
