<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatKewModel extends Model
{
    use HasFactory;
	protected $connection='pgsql';
    protected $table = 'cat_kew_plantsoftheworld';
	protected $primaryKey = 'ckew_taxonid';
	public $incrementing = false;
	protected $keyType = 'string';

    protected $fillable = [
        'ckew_family',
        'ckew_genus',
        'ckew_specificepithet',
        'ckew_infraspecificepithet',
        'ckew_scientfiicname',
        'ckew_scientfiicnameauthorship',
        'ckew_taxonrank',
        'ckew_taxonomicstatus',
        'ckew_acceptednameusageid',
        'ckew_parentnameusageid',
        'ckew_namepublishedin',
        'ckew_nomenclaturalstatus',
        'ckew_taxonremarks',
        'ckew_scientificnameid',
        'ckew_dynamicproperties',
        'ckew_reference',
        'ckew_references',
        //'Version',  ### Campo agregado por mi para indicar la versión de kew (o si es JEB)
    ];
}
