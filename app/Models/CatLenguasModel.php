<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatLenguasModel extends Model
{
    use HasFactory;
	protected $connection='pgsql';
	protected $table = 'cat_lenguas';
    #protected $table = 'lenguas_view';
	protected $primaryKey = 'clen_id';
	public $incrementing = true;
	#protected $keyType = 'string';

    // protected $fillable = [
    //     'clen_lengua',
    //     'clen_code',
    //     'clen_localidad',
    //     'clen_usuarios',
    //     'clen_status',
    //     'clen_altnames',
    //     'clen_autonimias',
    //     'clen_clasifica',
    //     'clen_originario',
    // ];
}
