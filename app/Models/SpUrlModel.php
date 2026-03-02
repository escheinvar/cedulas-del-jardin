<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SpUrlModel extends Model
{
     #use HasFactory;
	protected $connection='pgsql';
	protected $table = 'sp_url';
	protected $primaryKey = 'url_id';
	public $incrementing = true;
	#protected $keyType = 'string';

    protected $fillable = [
        'url_act',
        'url_url',
        'url_nombre',
        'url_reino',
        'url_sp',
        'url_nombrecomun',
        'url_sciname',
        'url_palabras',
    ];
}
