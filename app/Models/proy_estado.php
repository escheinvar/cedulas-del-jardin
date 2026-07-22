<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class proy_estado extends Model
{
    protected $connection='pgsql';
    protected $table = 'proy_estado';
    protected $primaryKey = 'predo_id';
    public $incrementing = true;
    #protected $keyType = 'string';
    protected $fillable = [
        'predo_proyid',
        'predo_act',
        'predo_del',
        'predo_edo',
        'predo_estado',
        'predo_comentario',
        'predo_fecha',
    ];

    protected static function boot() {
        parent::boot();
        static::saving(function ($registro) {
            $registro->predo_fecha=date('Y-m-d');
        });
    }

    public function proyecto():HasOne{
        return $this->hasOne(proy_proyectos::class, 'proy_id','predo_proyid')
            ->where('proy_del','0');
    }

    public function archivos():HasMany{
        return $this->hasMany(proy_archivos::class, 'prmat_predoid','predo_id')
            ->where('prmat_del','0')
            ->orderBy('prmat_id','desc');
    }

}
