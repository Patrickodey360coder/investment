<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'country',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function activities()
    {
        return $this->hasMany('App\Activity');
    }

    public function trustwayInvestments()
    {
        return $this->hasMany('App\TrustwayInvestment');
    }

    public function wallet()
    {
        return $this->hasOne('App\Wallet');
    }

    public function withdrawals()
    {
        return $this->hasMany('App\Withdrawal');
    }
}
