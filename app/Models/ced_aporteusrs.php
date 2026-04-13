<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ced_aporteusrs extends Model
{
    #use HasFactory;
	protected $connection='pgsql';
	protected $table = 'ced_aporteusrs';
	protected $primaryKey = 'msg_id';
	public $incrementing = true;
	#protected $keyType = 'string';

    protected $fillable = [
        'msg_id',
        'msg_act',
        'msg_del',

        'msg_estado',
        'msg_cjarsiglas',
        'msg_urlid',
        'msg_url',
        'msg_urltxt',

        'msg_nombre',
        'msg_usuario',
        'msg_edo',
        'msg_mpio',
        'msg_comunidad',
        'msg_lengua',
        'msg_edad',
        'msg_correo',
        'msg_tel',
        'msg_mensaje',
        'msg_mensajeoriginal',
        'msg_usr',
        'msg_date',
        'msg_nota',
    ];

    public function jardin():BelongsTo{
        return $this->belongsTo(CatJardinesModel::class,'msg_cjarsiglas','cjar_siglas');
    }

    public function cedula():BelongsTo{
        return $this->belongsTo(cedulas_url::class,'msg_urlid','url_id');
    }
}
