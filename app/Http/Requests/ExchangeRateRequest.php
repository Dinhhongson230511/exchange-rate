<?php

namespace App\Http\Requests;
use App\Rules\CheckIsExistCurrencyUnit;


class ExchangeRateRequest extends BaseParamsRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'symbols' => ['required', new CheckIsExistCurrencyUnit],
            'base' => ['required', new CheckIsExistCurrencyUnit],
        ];
    }
}
