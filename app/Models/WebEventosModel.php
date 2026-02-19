<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebEventosModel extends Model
{
    use HasFactory;
	protected $connection='pgsql';
	protected $table = 'www_eventos';
	protected $primaryKey = 'wwevs_id';
	public $incrementing = true;
	#protected $keyType = 'string';

    protected $fillable = [
        'wwevs_act',
        'wwevs_titulo',
        'wwevs_descrip',
        'wwevs_descrip2',
        'wwevs_label',
        'wwevs_lugar',
        'wwevs_dateini',
        'wwevs_datefin',
        'wwevs_timeini',
        'wwevs_timefin',
        'wwevs_costo',
        'wwevs_img',
    ];
}
