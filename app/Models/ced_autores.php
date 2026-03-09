<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
        'aut_correo',
        'aut_institucion',
        'aut_tipo',
        'aut_usrid',
    ];


}
