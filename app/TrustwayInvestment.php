<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrustwayInvestment extends Model
{
    protected $fillable = [
        'user_id', 'investment_amount', 'checkout_amount', 'status', 'investment_type', 'investment_date', 'checkout_date',
    ];

    protected static $statusValues = ['Active', 'Closed', 'Pending'];
    protected static $investmentTypes = ['Trustway 30', 'Trustway 90', 'Trustway 180', 'Trustway 360', 'Trustway Pension'];

    public static function getStatusValues()
    {
    	return self::$statusValues;
    }

    public static function getInvestmentTypes()
    {
    	return self::$investmentTypes;
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function trustwayPensionInvestment()
    {
        return $this->hasOne('App\TrustwayPensionInvestment');
    }
}
