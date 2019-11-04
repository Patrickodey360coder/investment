<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NewPremiumInvestment extends Model
{
    protected $fillable = [
        'user_id', 'investment_amount', 'months', 'from_wallet'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
