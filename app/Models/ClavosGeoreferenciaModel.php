<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClavosGeoreferenciaModel extends Model
{
    use HasFactory;
	protected $connection='pgsql';
	protected $table = 'pl_clavos_georeferencia_copy1';
	protected $primaryKey = 'cl_colectas_idcolectas';
	public $incrementing = false;
	protected $keyType = 'string';

    protected $fillable = [
        'cl_altitud',
        'cl_latitud',
        'cl_longitud',
        'cl_procedencia',
        'cl_municipio',
        'cl_distritos',
        'cl_nombre_region',
        'cl_nombre_estado',
        'cl_provincia_fisografica',
        'cl_area_protegida',
        'cl_iluminacion',
        'cl_topografia',
        'cl_exposicion',
        'cl_suelo',
        'cl_clima_zona',
        'cl_ph',
        'cl_temperatura',
        'cl_textura',
        'cl_color',
        'cl_pedregosidad',
        'cl_abundancia_zona',
        'cl_vegetacion_zona',
    ];
}
