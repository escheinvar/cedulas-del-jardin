<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SpUrlCedulaVersionModel extends Model
{
     #use HasFactory;
	protected $connection='pgsql';
	protected $table = 'sp_urlcedula_versiones';
	protected $primaryKey = 'cedv_id';
	public $incrementing = true;
	#protected $keyType = 'string';

    protected $fillable = [
        'cedv_id',
        'cedv_cedid',
        'cedv_cedversion',
        'cedv_usr',
        'cedv_pdf',
    ];
}
