<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class cat_img extends Model
{
    #use HasFactory;
	protected $connection='pgsql';
	protected $table = 'cat_img';
	protected $primaryKey = 'cimg_id';
	public $incrementing = true;
	#protected $keyType = 'string';

    protected $fillable = [
        'cimg_id',
        'cimg_modulo',
        'cimg_tipo',
        'cimg_explica',
    ];
}
