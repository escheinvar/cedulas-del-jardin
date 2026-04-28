<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class buzon extends Model
{
    // use HasFactory;
	protected $connection='pgsql';
	protected $table = 'buzon';
	protected $primaryKey = 'buz_id';
	public $incrementing = true;
	#protected $keyType = 'string';

    protected $fillable = [
        'buz_id',
        'buz_act',
        'buz_del',

        'buz_to',
        'buz_from',
        'buz_asunto',
        'buz_mensaje',

        'buz_notas',
        'buz_comp',
        'buz_date',
        'buz_hora',
        'buz_date_borrado',
        'buz_mailed',
        'buz_replyTo',
    ];

    public function para():HasOne {
        return $this->hasOne(user::class,'id', 'buz_to');
    }

    public function de():HasOne {
        return $this->hasOne(user::class,'id', 'buz_from');
    }
}
