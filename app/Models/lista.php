<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class lista extends Model
{
    #use HasFactory;
	protected $connection='pgsql';
	protected $table = 'lista';
	protected $primaryKey = 'lst_id';
	public $incrementing = true;
	#protected $keyType = 'string';

    protected $fillable = [
        'lst_id',
        'lst_act',
        'lst_del',
        'lst_cjarsiglas',
        'lst_edo',
        'lst_orden',

        'lst_reino',
        'lst_familia',
        'lst_genero',
        'lst_sp',
        'lst_ssp',
        'lst_scname',
        'lst_var',

        'lst_img',
        'lst_url',
        'lst_notas',
    ];
     public function nombres():HasMany {
        return $this->HasMany(lista_nombres::class,'lstn_lstid','lst_id')
            ->where('lstn_act','1')
            ->where('lstn_del','0');
    }
}
