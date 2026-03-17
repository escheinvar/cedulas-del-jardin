<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ced_sp extends Model
{
    #use HasFactory;
	protected $connection='pgsql';
	protected $table = 'ced_sp';
	protected $primaryKey = 'sp_id';
	public $incrementing = true;
	#protected $keyType = 'string';

    protected $fillable = [
        'sp_id',
        'sp_act',
        'sp_del',

        'sp_cjarsiglas',
        'sp_urltxt',

        'sp_scname',
        'sp_reino',
        'sp_familia',
        'sp_genero',
        'sp_especie',
        'sp_ssp',
        'sp_var',
    ];

    public function usos():HasMany{
        return $this->hasMany(ced_usos::class, 'uso_spid','sp_id')
            ->where('uso_act','1')
            ->where('uso_del','0')
            ->orderBy('uso_id','asc');
    }

    public function jardin():BelongsTo{
        return $this->belongsTo(CatJardinesModel::class,'cjar_siglas','sp_cjarsiglas');
    }

    public function cedula():BelongsTo{
        return $this->belongsTo(cedulas_url::class,'url_url','sp_urlurl');
    }
}
