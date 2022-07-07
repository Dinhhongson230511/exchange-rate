<?php

namespace App\Http\Controllers\ExchangeRate;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ExchangeRateService;
use Exception;
use App\Http\Requests\ExchangeRateRequest;

class ExchangeRateController extends Controller
{
    public function index() {
        return view('exchange_rate');
    }

    public function exchangeRate(ExchangeRateRequest $request, ExchangeRateService $exchangeRateService)
    {
        $respone = $exchangeRateService->exchangeRate($request);
        return $respone;
    }
}
