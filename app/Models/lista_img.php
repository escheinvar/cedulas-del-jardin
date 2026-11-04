<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class lista_img extends Model
{
    #use HasFactory;
	protected $connection='pgsql';
	protected $table = 'lista_img';
	protected $primaryKey = 'lstimg_id';
	public $incrementing = true;
	#protected $keyType = 'string';

    protected $fillable = [
        'lstimg_id',
        'lstimg_act',
        'lstimg_del',
        'lstimg_lstid',

        'lstimg_orden',
        'lstimg_img',

        'lstimg_titulo',
        'lstmig_autor',
        'lstmig_explica',
    ];

    public function ejemplar(): BelongsTo {
        return $this->belongsTo(lista::class, 'lstimg_lstid','lst_id');
    }
}
