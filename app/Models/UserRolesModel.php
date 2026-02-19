<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRolesModel extends Model
{
    use HasFactory;
	protected $connection='pgsql';
	protected $table = 'usr_roles';
	protected $primaryKey = 'rol_id';
	public $incrementing = true;
	#protected $keyType = 'string';

    protected $fillable = [
        'rol_act',
        'rol_usrid',
        #'rol_crolid',
        'rol_crolrol',
        'rol_tipo1',
        'rol_tipo2',

        'rol_describe',
    ];
}
