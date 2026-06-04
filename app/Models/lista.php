<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
        'lst_sp',
        'lst_var',

        'lst_name',
        'lst_notas',
    ];
}
