<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ced_version extends Model
{
    #use HasFactory;
	protected $connection='pgsql';
	protected $table = 'ced_version';
	protected $primaryKey = 'ver_id';
	public $incrementing = true;
	#protected $keyType = 'string';

    protected $fillable = [
        'ver_id',
        'ver_act',
        'ver_del',
        'ver_cedid',
        'ver_version',
        'ver_mes',
        'ver_anio',
        'ver_dia',
        'ver_hora',
        'ver_pdf',
    ];

}
