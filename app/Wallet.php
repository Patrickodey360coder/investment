<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
	protected $fillable = [
        'user_id', 'total_earnings', 'balance', 'withdrawable',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
