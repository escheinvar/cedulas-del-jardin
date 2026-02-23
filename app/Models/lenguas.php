<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class lenguas extends Model
{
     #use HasFactory;
	protected $connection='pgsql';
	protected $table = 'lenguas';
	protected $primaryKey = 'len_id';
	public $incrementing = true;
	#protected $keyType = 'string';

    protected $fillable = [
        'len_id',
        'len_code',
        'len_lengua',
        'len_variante',
        'len_altnames',
        'len_autonimias',
    ];
}
