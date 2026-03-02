<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class alias_img extends Model
{
    //  use HasFactory;
	protected $connection='pgsql';
	protected $table = 'alias_img';
	protected $primaryKey = 'aimg_id';
	public $incrementing = true;
	#protected $keyType = 'string';

    protected $fillable = [
        'aimg_id',
        'aimg_imgid',
        'aimg_act',
        'aimg_del',
        'aimg_txt',
        'aimg_lencode',
    ];
}
