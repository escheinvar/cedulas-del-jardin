<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class lista_nombresc extends Model
{
    protected $connection='pgsql';
	protected $table = 'lista_nombresc';
	protected $primaryKey = 'lstn_id';
	public $incrementing = true;
	#protected $keyType = 'string';

    protected $fillable = [
        'lstsc_id',
        'lstsc_act',
        'lstsc_del',
        'lstsc_lstid',

        'lstsc_reino',
        'lstsc_familia',
        'lstsc_genero',
        'lstsc_sp',
        'lstsc_ssp',
        'lstsc_scname',
        'lstsc_var',
    ];

    public function ejemplar(): BelongsTo {
        return $this->belongsTo(lista::class, 'lstsc_lstid','lst_id');
    }


}
