<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CatLenguasInaliModel extends Model
{
    #use HasFactory;
	protected $connection='pgsql';
	protected $table = 'cat_lenguas_inali';
	protected $primaryKey = 'clen2_id';
	public $incrementing = true;
	#protected $keyType = 'string';

    protected $fillable = [
        'clen2_lengua',
        'clen2_autonimias',
        'clen2_localidad',
        'clen2_usuarios',
        'clen2_code',
        'clen2_fam',
        'clen2_rama',
        'clen2_subgroup',
    ];
}
