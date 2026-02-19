<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatEntidadesInegiModel extends Model
{
    use HasFactory;
	protected $connection='pgsql';
	protected $table = 'cat_entidades_inegi';
	protected $primaryKey = 'cedo_id';
	public $incrementing = true;
	#protected $keyType = 'string';

    protected $fillable = [
        'cedo_nombre',
        'cedo_abrevia',
    ];
}
