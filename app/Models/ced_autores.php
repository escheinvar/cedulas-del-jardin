<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ced_autores extends Model
{
    #use HasFactory;
	protected $connection='pgsql';
	protected $table = 'ced_autores';
	protected $primaryKey = 'aut_id';
	public $incrementing = true;
	#protected $keyType = 'string';

    protected $fillable = [
        'aut_id',
        'aut_cautid',
        'aut_urlid',
        'aut_act',
        'aut_del',
        'aut_orden',
        'aut_corresponding',
        'aut_name',
        'aut_correo',
        'aut_comunidad',
        'aut_institucion',
        'aut_tipo',
        'aut_usrid',
    ];

    public function autor():BelongsTo{
        return $this->belongsTo(cat_autores::class,'aut_cautid','caut_id');
    }

    public function cedula():BelongsTo{
        return $this->belongsTo(cedulas_url::class,'aut_urlid','url_id');
    }

}
