<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class lista_nombres extends Model
{
    #use HasFactory;
	protected $connection='pgsql';
	protected $table = 'lista_nombres';
	protected $primaryKey = 'lstn_id';
	public $incrementing = true;
	#protected $keyType = 'string';

    protected $fillable = [
        'lstn_id',
        'lstn_act',
        'lstn_del',
        'lstn_lstid',
        'lstn_name',
        'lstn_audio',
        'lstn_lengua',
        'lstn_lencode',
    ];

    public function ejemplar(): BelongsTo {
        return $this->belongsTo(lista::class, 'lstn_lstid','lst_id');
    }

}
