<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class jue_memoria extends Model
{
    #use HasFactory;
	protected $connection='pgsql';
	protected $table = 'jue_memoria';
	protected $primaryKey = 'mem_id';
	public $incrementing = true;
	#protected $keyType = 'string';

     protected $fillable = [
        'mem_id',
        'mem_jueid',
        'mem_act',
        'mem_del',
        'mem_name',
        'mem_par',
        'mem_txt',
        'mem_img',
        'mem_aud',
     ];
}
