<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class jardin_url extends Model
{
    #use HasFactory;
	protected $connection='pgsql';
	protected $table = 'jardin_url';
	protected $primaryKey = 'urlj_id';
	public $incrementing = true;
	#protected $keyType = 'string';

    protected $fillable = [
        'urlj_id',
        'urlj_act',
        'urlj_del',
        'urlj_edit',
        'urlj_cjarsiglas',
        'urlj_cjarsiglas',

        'urlj_url',
        'urlj_titulo',
        'urlj_descrip',
        'urlj_bannerimg',
        'urlj_bannertitle',
    ];
}
