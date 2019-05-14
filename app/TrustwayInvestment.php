<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TrustwayInvestment extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id', 'investment_amount', 'checkout_amount', 'status', 'investment_type', 'investment_date', 'checkout_date',
    ];

    protected static $statusValues = ['Active', 'Closed', 'Pending'];
    protected static $investmentTypes = ['Trustway 90', 'Trustway 180', 'Trustway 360', 'Trustway Pension'];

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
}
