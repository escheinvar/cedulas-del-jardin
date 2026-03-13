<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ced_catalogos extends Model
{
    #use HasFactory;
	protected $connection='pgsql';
	protected $table = 'ced_catalogo';
	protected $primaryKey = 'cat_id';
	public $incrementing = true;
	#protected $keyType = 'string';

    protected $fillable = [
        'cat_id',
        'cat_tipo',
        'cat_valor',
        'cat_explica',
    ];
}
