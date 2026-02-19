<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatRolesModel extends Model
{
    use HasFactory;
	protected $connection='pgsql';
	protected $table = 'cat_roles';
	protected $primaryKey = 'crol_id';
	public $incrementing = true;
	#protected $keyType = 'string';

    protected $fillable = [
        'crol_rol',
        'crol_mod',
        'crol_describe',
        'crol_notas',
    ];
}
