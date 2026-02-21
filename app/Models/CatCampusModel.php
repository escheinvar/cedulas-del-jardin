<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatCampusModel extends Model
{
    use HasFactory;
	protected $connection='pgsql';
	protected $table = 'cat_campus';
	protected $primaryKey = 'ccam_id';
	public $incrementing = true;
	#protected $keyType = 'string';

    protected $fillable = [
        'ccam_act',
        'ccam_del',
        'ccam_cjarid',
        'ccam_name',
        'ccam_nombre',
        'ccam_direccion',
    ];
}
