<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class sist_visitas extends Model
{
    protected $connection='pgsql';
	protected $table = 'sist_visitas';
	protected $primaryKey = 'vis_id';
	public $incrementing = true;
    #protected $keyType = 'string';
    protected $fillable = [
        'vis_id',
        'vis_entrada',

        'vis_jardin',
        'vis_modulo',
        'vis_urltxt',
        'vis_lengua',
        'vis_url',
        'vis_flag',

        'vis_ip',
        'vis_locale',
        'vis_pais',
        'vis_region',
        'vis_ciudad',
        'vis_x',
        'vis_y',

        'vis_usr',
        'vis_rol',
        'vis_tocken',
    ];

    protected static function boot() {
        parent::boot();
        static::saving(function ($registro) {
            $registro->vis_anio=date('Y');
            $registro->vis_mes=date('m');
            $registro->vis_dia=date('d');
            $registro->vis_fecha=date('Y-m-d');
            $registro->vis_hora=date('H:i:s');
        });
    }
}
