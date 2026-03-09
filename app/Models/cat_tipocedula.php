<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class cat_tipocedula extends Model
{
    #use HasFactory;
	protected $connection='pgsql';
	protected $table = 'cat_tipocedulas';
	protected $primaryKey = 'cced_id';
	public $incrementing = true;
	#protected $keyType = 'string';

    protected $fillable = [
        'cced_id',
        'cced_tipo',
    ];
}
