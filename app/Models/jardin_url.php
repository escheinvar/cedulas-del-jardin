<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class jardin_url extends Model
{
    #use HasFactory;
	protected $connection='pgsql';
	protected $table = 'jardin_url';
	protected $primaryKey = 'urlj_id';
	public $incrementing = true;
	#protected $keyType = 'string';

    protected $fillable = [
        'urlj_id',
        'urlj_act',
        'urlj_del',
        'urlj_edit',
        'urlj_cjarsiglas',
        'urlj_tradid',
        'urlj_lencode',

        'urlj_url',
        'urlj_urltxt',
        'urlj_titulo',
        'urlj_descrip',
        'urlj_bannerimg',
        'urlj_bannertitle',
    ];

    public function jardin(): BelongsTo {
        return $this->belongsTo(CatJardinesModel::class,'urlj_cjarsiglas','cjar_siglas');
    }

    public function lenguas(): BelongsTo {
        return $this->belongsTo(lenguas::class, 'urlj_lencode','len_code');
    }

    // public function objetos(){
    //     return $this->hasMany(Imagenes::class)
    //         ->where('img_cjarsiglas','urlj_cjarsiglas','img_cjarsiglas')
    //         ->where('img_cimgmodulo','jardin')
    //         // ->where('img_cimgtipo','web')
    //         ;
    // }

    // public function original(): HasOne{
    //     return $this->hasOne(jardin_url::class, 'urlj_cjarsiglas');
    // }

}
