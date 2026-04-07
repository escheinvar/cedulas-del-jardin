<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class jardin_txt extends Model
{
     #use HasFactory;
	protected $connection='pgsql';
	protected $table = 'jardin_txt';
	protected $primaryKey = 'jar_id';
	public $incrementing = true;
	#protected $keyType = 'string';

    protected $fillable = [
        'jar_id',
        'jar_urljid',
        'jar_cjarsiglas',
        'jar_urljurl',
        'jar_act',
        'jar_del',

        'jar_tipo',
        'jar_orden',
        'jar_txt',
        'jar_txtoriginal',
        'jar_audio',
        'jar_version',
    ];

    public function url():BelongsTo {
        return $this->belongsTo(jardin_url::class,'jar_urljid','urlj_id');
    }
}
