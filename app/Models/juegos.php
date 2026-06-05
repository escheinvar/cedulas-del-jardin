<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class juegos extends Model
{
    #use HasFactory;
	protected $connection='pgsql';
	protected $table = 'juegos';
	protected $primaryKey = 'jue_id';
	public $incrementing = true;
	#protected $keyType = 'string';

     protected $fillable = [
        'jue_id',
        'jue_act',
        'jue_del',
        'jue_cjarsiglas',
        'jue_tipo',
        'jue_name',
        'jue_portada',

        'jue_cita',
        'jue_cita_aut',
        'jue_anio',
        'jue_version',
     ];


    public function cartas():HasMany{
        return $this->hasMany(jue_memoria::class,'mem_jueid','jue_id');
    }
}
