<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class jardin_txt extends Model
{
     #use HasFactory;
	protected $connection='pgsql';
	protected $table = 'jardin_txt';
	protected $primaryKey = 'jar_id';
	public $incrementing = true;
	#protected $keyType = 'string';

    protected $fillable = [
        'jar_id',
        'jar_urljid',
        'jar_urljurl',
        'jar_cjarsiglas',
        'jar_act',
        'jar_del',

        'jar_orden',
        'jar_txt',
        'jar_arch1',
        'jar_arch2',
        'jar_arch3',
        'jar_arch4',
        'jar_arch5',
    ];
}
