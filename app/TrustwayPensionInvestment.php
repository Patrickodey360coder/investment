<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrustwayPensionInvestment extends Model
{
    protected $fillable = [
        'next_payout_amount', 'next_payout_date', 'trustway_investment_id', 'duration',
    ];

    public function trustwayInvestment()
    {
        return $this->belongsTo('App\TrustwayInvestment');
    }
}
