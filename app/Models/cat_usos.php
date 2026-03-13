<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class cat_usos extends Model
{
    #use HasFactory;
	protected $connection='pgsql';
	protected $table = 'cat_usos';
	protected $primaryKey = 'cuso_id';
	public $incrementing = true;
	#protected $keyType = 'string';

    protected $fillable = [
        'cuso_id',
        'cuso_catego',
        // 'cuso_parte',
        'cuso_uso',
        'cuso_describe',
    ];
}
