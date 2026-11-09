<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class lista_usos extends Model
{
     protected $connection='pgsql';
	protected $table = 'lista_usos';
	protected $primaryKey = 'lsuso_id';
	public $incrementing = true;
	#protected $keyType = 'string';

    protected $fillable = [
        'lsuso_id',
        'lsuso_act',
        'lsuso_del',
        'lsuso_lstid',

        'lsuso_catego',
        'lsuso_uso',
        'lsuso_describe',

        'lsuso_parte',
        'lsuso_nota',
    ];

     public function ejemplar(): BelongsTo {
        return $this->belongsTo(lista::class, 'lsuso_lstid','lst_id');
    }

}
