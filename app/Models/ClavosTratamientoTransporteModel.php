<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClavosTratamientoTransporteModel extends Model
{
    use HasFactory;
	protected $connection='pgsql';
	protected $table = 'pl_clavos_tratamiento_transporte';
	protected $primaryKey = 'cl_id3';
	public $incrementing = true;
	protected $keyType = 'string';

    protected $fillable = [
        'cl_colectas_copy1_idcolectas',
        'cl_personas_recolectar',
        'cl_fecha_inicio',
        'cl_fecha_corte',
        'cl_fecha_tratamiento',
        'cl_fecha_embalaje',
        'cl_fecha_extraccion',
        'cl_tipo_extraccion',
        'cl_fecha_carga_envio',
        'cl_tipo_vehiculo',
        'cl_fecha_llegada',
        'cl_fecha_descarga',
        'cl_observaciones',
        'cl_nombre_responsable_tecnico',
        'cl_nombre_responsable_operativo',

    ];
}
