<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PremiumUser extends Model
{
    protected $fillable = [
        'user_id', 'investment_amount', 'months', 'investment_date', 'next_checkout_date', 'expiration_date',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
