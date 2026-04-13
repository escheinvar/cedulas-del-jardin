<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class cat_redes extends Model
{
     #use HasFactory;
	protected $connection='pgsql';
	protected $table = 'cat_redes';
	protected $primaryKey = 'red_id';
	public $incrementing = true;
	#protected $keyType = 'string';

    protected $fillable = [
        'red_id',
        'red_name',
        'red_url',
        'red_icon',
    ];

}
