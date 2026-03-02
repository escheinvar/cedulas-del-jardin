<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
        'caut_tipo',
        'caut_nombre',
        'caut_apellidos',
        'caut_nombreautor',
        'caut_correo',
        'caut_institu',
        'caut_usrid',
        'caut_lenguas',
        'caut_web',
        'caut_mailpublic',
        'caut_orcid',
        'caut_img',
    ];
}
