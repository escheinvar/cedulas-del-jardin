<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SistVisitasModel extends Model
{
    protected $connection='pgsql';
	protected $table = 'sist_visitas';
	protected $primaryKey = 'vis_id';
	public $incrementing = true;
    #protected $keyType = 'string';
    protected $fillable = [
        'vis_id',
        'vis_unique',
        'vis_ip',
        'vis_url',
        'vis_url2',
        'vis_url3',
        'vis_locale',
        'vis_locale2',
        'vis_tocken',
        'vis_pais',
        'vis_regionname',
        'vis_ciudad',
        'vis_x',
        'vis_y',
        'vis_usr',
        'vis_rol',
    ];
}
