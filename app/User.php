<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'country', 'role', 'phone'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public static function boot() {
        parent::boot();

        static::deleting(function($user) { // before delete() method call this
            $user->bankAccount->delete();
            $user->wallet->delete();
            PremiumUser::where('user_id', $user->id)->delete();
            NewPremiumInvestment::where('user_id', $user->id)->delete();
            Activity::where('user_id', $user->id)->delete();
            Withdrawal::where('user_id', $user->id)->delete();
            foreach ($user->trustwayInvestments as $investment) {
                TrustwayPensionInvestment::where('trustway_investment_id', $investment->id)->delete();
            }
            TrustwayInvestment::where('user_id', $user->id)->delete();
        });
    }

    public function bankAccount()
    {
        return $this->hasOne('App\BankAccount');
    }

    public function premiumUser()
    {
        return $this->hasOne('App\PremiumUser');
    }

    public function newPremiumInvestment()
    {
        return $this->hasOne('App\NewPremiumInvestment');
    }

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
