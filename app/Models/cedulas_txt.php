<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class cedulas_txt extends Model
{
    #use HasFactory;
	protected $connection='pgsql';
	protected $table = 'cedula_txt';
	protected $primaryKey = 'txt_id';
	public $incrementing = true;
	#protected $keyType = 'string';

    protected $fillable = [
        'txt_id',
        'txt_cjarsiglas',
        'txt_urlid',
        'txt_urlurl',

        'txt_act',
        'txt_del',
        'txt_tipo',
        'txt_orden',

        'txt_txt',
        'txt_txtoriginal',
        'txt_audio',
        'txt_version',
    ];


}
