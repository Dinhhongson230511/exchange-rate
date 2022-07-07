<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CheckIsExistCurrencyUnit implements Rule
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
        return \App\Helpers\Caches\CurrencyUnitCache::checkIsExist($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Đơn vị tiền tệ không hợp lệ.';
    }
}
