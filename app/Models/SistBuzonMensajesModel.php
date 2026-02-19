<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SistBuzonMensajesModel extends Model
{

	protected $connection='pgsql';
	protected $table = 'sist_buzon_mensajes';
	protected $primaryKey = 'buz_id';
	public $incrementing = true;

    protected $keyType = 'string';    protected $fillable = [
        'buz_id',
        'buz_act',
        'buz_leido',
        'buz_modulo',

        'buz_usr_origen',
        'buz_destino_usr',
        'buz_destino_rol',
        'buz_asunto',
        'buz_mensaje',
        'buz_notas',
        'buz_date_origen',
        'buz_date_leido',
        'buz_date_borrado',
    ];

}
