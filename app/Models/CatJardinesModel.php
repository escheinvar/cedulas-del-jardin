<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatJardinesModel extends Model
{
    use HasFactory;
	protected $connection='pgsql';
	protected $table = 'cat_jardines';
	protected $primaryKey = 'cjar_id';
	public $incrementing = true;
	#protected $keyType = 'string';

    protected $fillable = [
        'cjar_name',
        'cjar_nombre',
        'cjar_siglas',
        'cjar_act',
        'cjar_del',
        'cjar_tipo',
        'cjar_direccion',
        'cjar_tel',
        'cjar_mail',
        'cjar_edo',
        'cjar_logo',

        'cjar_face',
        'cjar_insta',
        'cjar_youtube',
        'cjar_www',
        'cjar_red1',
        'cjar_red2',
        'cjar_red3',
        'cjar_ubica',
    ];
}
