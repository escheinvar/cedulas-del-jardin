<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SpCedulasModel extends Model
{
    #use HasFactory;
	protected $connection='pgsql';
	protected $table = 'sp_cedulas';
	protected $primaryKey = 'txt_id';
	public $incrementing = true;
	#protected $keyType = 'string';

    protected $fillable = [
        'txt_cedid',
        'txt_act',
        'txt_titulo',
        'txt_order',
        'txt_codigo',
        'txt_audio',
        'txt_autor',
        'txt_version',
        'txt_img1',
        'txt_img2',
        'txt_img3',
        'txt_video',
        'txt_resp',
    ];
}
