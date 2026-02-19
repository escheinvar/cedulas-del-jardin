<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstitucionesModel extends Model
{
    use HasFactory;
	protected $connection='pgsql';
	protected $table = 'cat_instituciones';
	protected $primaryKey = 'cins_id';
	public $incrementing = true;
	#protected $keyType = 'string';

    protected $fillable = [
        'cins_institucion',
    ];
}
