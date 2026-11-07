<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class lista_txt extends Model
{
    protected $connection='pgsql';
	protected $table = 'lista_txt';
	protected $primaryKey = 'lstxt_id';
	public $incrementing = true;
	#protected $keyType = 'string';

    protected $fillable = [
        'lstxt_id',
        'lstxt_act',
        'lstxt_del',
        'lstxt_cjarsiglas',
        'lstxt_tipo',
        'lstxt_orden',

        'lstxt_txt',
        'lstxt_txtoriginal',
        'lstxt_audio',
    ];
}
