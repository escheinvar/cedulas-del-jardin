<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

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
        'rol_del',
        'rol_usrid',
        'rol_cjarsiglas',
        'rol_crolrol',
        'rol_lencode',
        'rol_urlid',
        'rol_tipo1',
        'rol_tipo2',
        'rol_describe',
    ];

    public function rol():HasOne {
        return $this->hasOne(CatRolesModel::class,'crol_rol', 'rol_crolrol');
    }
    // public function rol():BelongsTo{
    //     return $this->belongsTo()
    // }
}
