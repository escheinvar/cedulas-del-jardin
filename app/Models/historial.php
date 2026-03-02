<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class historial extends Model
{
   # use HasFactory;
	protected $connection='pgsql';
	protected $table = 'historial';
	protected $primaryKey = 'log_id';
	public $incrementing = true;
	#protected $keyType = 'string';

    protected $fillable = [
        'log_id',
        'log_log',
        'log_tabla',
        'log_tablaid',
        'log_explica',
        'log_usrid',
        'log_fecha',
        'log_Hora',
    ];
}
