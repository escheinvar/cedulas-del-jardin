<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class proy_proyectos extends Model
{
    protected $connection='pgsql';
	protected $table = 'proy_proyectos';
	protected $primaryKey = 'proy_id';
	public $incrementing = true;
    #protected $keyType = 'string';
    protected $fillable = [
        'proy_titulo',
        'proy_jardin',
        'proy_act',
        'proy_del',
        'proy_autor1',
        'proy_autor2',
        'proy_autor3',
        'proy_admin',
        'proy_editor',
        'proy_fecha',
    ];

    protected static function boot() {
        parent::boot();
        static::saving(function ($registro) {
            $registro->proy_fecha=date('Y-m-d');
        });
    }

    public function estados():HasMany{
        return $this->hasMany(proy_estado::class, 'predo_proyid','proy_id')
            ->where('predo_del','0')
            ->orderBy('predo_id','desc');
    }
    public function archivos():HasMany{
        return $this->hasMany(proy_archivos::class, 'prmat_proyid','proy_id')
            ->where('prmat_del','0')
            ->orderBy('prmat_id','desc');
    }
    public function autor1():HasOne{
        return $this->hasOne(User::class, 'id','proy_autor1');
    }
    public function autor2():HasOne{
        return $this->hasOne(User::class, 'id','proy_autor2');
    }
    public function autor3():HasOne{
        return $this->hasOne(User::class, 'id','proy_autor3');
    }
    public function editor():HasOne{
        return $this->hasOne(User::class, 'id','proy_editor');
    }
    public function admin():HasOne{
        return $this->hasOne(User::class, 'id','proy_admin');
    }

}
