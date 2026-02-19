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
        'cjar_tipo',
        'cjar_direccion',
        'cjar_tel',
        'cjar_mail',
        'cjar_edo',
        'cjar_logo',
    ];
}
