<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClavosColectasModel extends Model
{
    use HasFactory;
	protected $connection='pgsql';
	protected $table = 'pl_clavos_colectas_copy1';
	protected $primaryKey = 'cl_idcolectas';
	public $incrementing = false;
	protected $keyType = 'string';

    protected $fillable = [
            'cl_numero_clavo',
            'cl_letra',
            'cl_comentarios',
            'cl_recolector',
            'cl_fecha',
            'cl_datos_etnobotanicos',
            'cl_plantas_idplantas',
            'cl_nombre_comun',
            'cl_genero',
            'cl_especie',
            'cl_familia',
            'cl_protegida',
            'cl_numero_salida',
            'cl_caracteristica_raiz',
            'cl_altura_planta',
            'cl_dap',
            'cl_diametro_tronco',
            'cl_diametro_raiz',
            'cl_cobertura',
            'cl_diametro_cepellon',
            'cl_altura_cepellon',
            'cl_estado',
            'cl_forma_biologica',
            'cl_conformacion_cepellon',
            'cl_estado_fenologico',
            'cl_ciclo_vida',
            'cl_comentarios_de_registro',
            'cl_tipo_raiz',
            'cl_forma_colecta',
            'cl_revision',
            'cl_link',
            'cl_usuarios_idusuarios',
            'cl_username',
            'cl_active',
    ];
}
