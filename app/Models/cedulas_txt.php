<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class cedulas_txt extends Model
{
    #use HasFactory;
	protected $connection='pgsql';
	protected $table = 'cedula_txt';
	protected $primaryKey = 'ced_id';
	public $incrementing = true;
	#protected $keyType = 'string';

    protected $fillable = [
        'ced_id',
        'ced_urlid',
        'ced_urlid',
        'ced_cjarsiglas',
        'ced_cjarsiglas',
        'ced_urlurl',
        'ced_urlurl',

        'ced_act',
        'ced_del',
        'ced_orden',

        'ced_txt',
        'ced_txtoriginal',
        'ced_audio',
        'ced_version',
    ];


}
