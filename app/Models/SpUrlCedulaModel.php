<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SpUrlCedulaModel extends Model
{
    #use HasFactory;
	protected $connection='pgsql';
	protected $table = 'sp_urlcedula';
	protected $primaryKey = 'ced_id';
	public $incrementing = true;
	#protected $keyType = 'string';

    protected $fillable = [
        'ced_id',
        'ced_act',
        'ced_urlurl',
        'ced_clencode',
        'ced_cjarsiglas',
        'ced_edo',
        'ced_version',
        'ced_versiondate',
        'ced_cita',
        'ced_doi',
    ];
}
