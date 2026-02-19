<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SpAporteUsrsModel extends Model
{
     #use HasFactory;
	protected $connection='pgsql';
	protected $table = 'sp_aporte_usrs';
	protected $primaryKey = 'msg_id';
	public $incrementing = true;
	#protected $keyType = 'string';

    protected $fillable = [
        'msg_id',
        'msg_act',
        'msg_edo',
        'msg_cedid',
        'msg_usr',
        'msg_usuario',
        'msg_origen',
        'msg_edad',
        'msg_mensaje',
        'msg_date',
    ];
}
