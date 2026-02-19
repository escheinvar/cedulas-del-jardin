<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class nom054semarnat extends Model
{
    // use HasFactory;
	protected $connection='pgsql';
	protected $table = 'nom054semarnat';
	protected $primaryKey = 'nom_id';
	public $incrementing = true;
	#protected $keyType = 'string';

    protected $fillable = [
        'nom_id',
        'nom_grupo',
        'nom_subgrupo',
        'nom_familia',
        'nom_genero',
        'nom_especie',
        'nom_catinfrasp',
        'nom_infrasp',
        'nom_autor',
        'nom_sinonimia',
        'nom_comunname',
        'nom_distri',
        'nom_cat',
    ];
}
