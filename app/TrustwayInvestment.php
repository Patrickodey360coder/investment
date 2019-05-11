<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrustwayInvestment extends Model
{
    protected static $statusValues = ['Active', 'Closed', 'Pending'];
    protected static $investmentTypes = ['Trustway 90', 'Trustway 180', 'Trustway 360'];

    public static function getStatusValues()
    {
    	return self::$statusValues;
    }

    public static function getInvestmentTypes()
    {
    	return self::$investmentTypes;
    }
}
