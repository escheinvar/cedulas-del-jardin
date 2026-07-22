<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class proy_archivos extends Model
{
    protected $connection='pgsql';
    protected $table = 'proy_archivos';
    protected $primaryKey = 'prmat_id';
    public $incrementing = true;
    #protected $keyType = 'string';
    protected $fillable = [
        'prmat_proyid',
        'prmat_predoid',
        'prmat_del',
        'prmat_edo',
        'prmat_archivo',
        'prmat_nombrearch',
        'prmat_tipo',
        'prmat_usr',
        'prmat_comentario',
    ];
}
