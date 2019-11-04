<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidateNewPremiumInvestmentAmount implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    private $wallet;

    public function __construct($wallet)
    {
        $this->wallet = $wallet;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $from_wallet = $_POST['from_wallet'] ?? '';
        
        if($from_wallet === 'yes'){
            return $_POST['amount'] <= $this->wallet->withdrawable;
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'You can only have an investment of '.$this->wallet->withdrawable.' from your wallet';
    }
}
