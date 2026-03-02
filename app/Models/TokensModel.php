<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TokensModel extends Model
{
    use HasFactory;
	protected $connection='pgsql';
	protected $table = 'usr_tokens';
	protected $primaryKey = 'tok_id';
	public $incrementing = true;
	#protected $keyType = 'string';

    protected $fillable = [
        'tok_act',
        'tok_mail',
        'tok_token',
        'tok_ini',
        'tok_fin',
    ];
}
