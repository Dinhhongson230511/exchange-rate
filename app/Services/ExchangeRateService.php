<?php
namespace App\Services;

use Illuminate\Http\Response;

class ExchangeRateService
{
    public function exchangeRate($request) {

        $server = new ExchangeService;

        $getRate = $server->exchangeRate($request);

        $getAverageExchangeRate = $server->averageExchangeRate($request);

        $sign = "";
        if($getRate > $getAverageExchangeRate) {
            $sign = 'Up';
        } elseif ($getRate < $getAverageExchangeRate) {
            $sign = 'Down';
        } elseif ($getRate == $getAverageExchangeRate) {
            $sign = 'Balance';
        }

        $data = [
            'rate' => $getRate,
            'averageExchangeRate' => $getAverageExchangeRate,
            'sign' => $sign
        ];
       
        return [
            'data' => $data,
            'status' => Response::HTTP_OK
        ];
    }
}