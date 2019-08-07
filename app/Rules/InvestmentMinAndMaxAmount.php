<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class InvestmentMinAndMaxAmount implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        $amount = $_POST['amount'] ?? 0;
        $amount = (int) $amount;
        $investmentType = $_POST["investment-type"] ?? '';

        switch ($investmentType) {
            case 'Trustway 30':
            case 'Trustway 90':
            case 'Trustway 180':
                return $amount >= 25000;
            case 'Trustway 360':
                return $amount >= 50000;
            case 'Trustway Pension':
                return $amount >= 100000;
            default:
                return false;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        $amount = $_POST['amount'] ?? 0;
        $amount = (int) $amount;
        $investmentType = $_POST["investment-type"] ?? '';

        switch ($investmentType) {
            case 'Trustway 30':
            case 'Trustway 90':
            case 'Trustway 180':
                return $investmentType . " investment amount can not be less than 25000";

            case 'Trustway 360':
                return $investmentType . " investment amount can not be less than 50000";

            case 'Trustway Pension':
                return $investmentType . " investment amount can not be less than 100000";

            default:
                return "";
        }
    }
}
