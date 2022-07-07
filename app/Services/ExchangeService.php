<?php

namespace App\Services;

use App\Base\Support\RequestUrl;
use App\Helpers\Caches\ExchangeRateNowCache;
use App\Helpers\Caches\ExchangeRateOldCache;
use App\Repositories\ExchangeRateNowRepository;
use App\Repositories\ExchangeRateOldRepository;
use App\Models\ExchangeRateNow;
use App\Models\ExchangeRateOld;

class ExchangeService
{
    public function exchangeRate($request)
    {
        $symbols = $request->symbols;
        $base = $request->base;

        if($symbols == $base) return 1;

        if($symbols == UNIT_DEFAUT) {
            $rate_symbols = 1;
        }else {
            $rate_symbols = $this->getRate($symbols);
        }

        if($base == UNIT_DEFAUT) {
            $rate_base = 1;
        }else {
            $rate_base = $this->getRate($base);
        }

        $rate = $rate_symbols / $rate_base;

        return round($rate, 5);
    }

    /**
     * 
     */
    public function getRate($symbols)
    {
        $exchange_rate_now_cache = ExchangeRateNowCache::get($symbols);

        if($exchange_rate_now_cache) {
            return $exchange_rate_now_cache->getColRate();
        }

        $new_rate = $this->callNewRate($symbols);

        $model_rate_now = new ExchangeRateNowRepository;

        $check_rate = $model_rate_now->getByUnit($symbols);

        $params = [
            ExchangeRateNow::COL_UNIT => removeAccent($symbols),
            ExchangeRateNow::COL_BASE => removeAccent(UNIT_DEFAUT),
            ExchangeRateNow::COL_RATE => $new_rate,
        ];

        if(!$check_rate) {
            $params[ExchangeRateNow::COL_TIME_CREATED] = dateTime();
            $model_rate_now->create($params);
        }else {
            $params[ExchangeRateNow::COL_TIME_UPDATED] = dateTime();
            $check_rate->update($params);
        }

        return $new_rate;
    }

    /**
     * 
     */
    public function callNewRate($symbols)
    {
        $params = [
            'symbols' => $symbols,
            'base' => UNIT_DEFAUT,
        ];
        $url = config('exchange-rate.prefix_url_latest');

        $api_url = config('exchange-rate.api_url') . '/' . $url;

        $headers = [
            'Content-Type' => 'text/plain',
            'apikey' => config('exchange-rate.api_key')
        ];


        $result = RequestUrl::call($api_url, 'get', $headers, $params, 'json', true);
        if($result['status'] != 200) {
            throw new \Exception('invalid exchange rate');
            
        }
        
        $response = (array)$result['response'];
        $rates = (array)$response['rates'];
        $rate = $rates[strtoupper($symbols)];

        return $rate;
    }

    /**
     * 
     */
    public function averageExchangeRate($request)
    {
        $symbols = $request->symbols;
        $base = $request->base;

        if($symbols == $base) return 1;

        if($symbols == UNIT_DEFAUT) {
            $average_symbols = 1;
        }else {
            $average_symbols = $this->getAverageExchangeRate($symbols);
        }


        if($base == UNIT_DEFAUT) {
            $average_base = 1;
        }else {
            $average_base = $this->getAverageExchangeRate($base);
        }

        $rate = $average_symbols / $average_base;

        return round($rate, 5);
    }

    public function getAverageExchangeRate($symbols)
    {
        $exchange_rate_cache = ExchangeRateOldCache::get($symbols);

        if($exchange_rate_cache) {
            return $exchange_rate_cache->getColRate();
        }

        $new_rate = $this->callAverageExchangeRate($symbols);

        $rate = $new_rate['medium']; 
        $rate_date = $new_rate['data'];

        $model_rate_old = new ExchangeRateOldRepository;

        $check_rate = $model_rate_old->getByUnit($symbols);

        $params = [
            ExchangeRateOld::COL_UNIT => removeAccent($symbols),
            ExchangeRateOld::COL_BASE => removeAccent(UNIT_DEFAUT),
            ExchangeRateOld::COL_RATE => $rate,
            ExchangeRateOld::COL_RATE_DATE => json_encode($rate_date),
            ExchangeRateOld::COL_NUMBER_RATE => NUMBER_DATE_SAVE_RATES,
            ExchangeRateOld::COL_DATE_UPDATE => getDay(),
        ];

        if(!$check_rate) {
            $params[ExchangeRateOld::COL_TIME_CREATED] = dateTime();

            $model_rate_old->create($params);
        }else {
            $params[ExchangeRateOld::COL_TIME_UPDATED] = dateTime();
            $check_rate->update($params);
        }

        return $rate;
    }

    public function callAverageExchangeRate($symbols)
    {
        $params = [
            'end_date' => getDay(),
            'start_date' => getDay(-NUMBER_DATE_SAVE_RATES),
            'symbols' => $symbols,
            'base' => UNIT_DEFAUT,
        ];
        $url = config('exchange-rate.prefix_url_timeseries');

        $api_url = config('exchange-rate.api_url') . '/' . $url;

        $headers = [
            'Content-Type' => 'text/plain',
            'apikey' => config('exchange-rate.api_key')
        ];

        
        $result = RequestUrl::call($api_url, 'get', $headers, $params, 'json', true);
        if($result['status'] != 200) {
            throw new \Exception('invalid exchange rate');
        }

        $response = (array)$result['response'];
        $rates = (array)$response['rates'];
        
        $data = [];
        $total_rate = 0;
        foreach ($rates as $key => $value) {
            $value = (array) $value;
            $rate = $value[strtoupper($symbols)];
            $data[$key] = $rate;
            $total_rate += $rate;
        }

        $medium = $total_rate / count($data);
        $medium = round($medium, 5);
        return [
            'data' => $data,
            'medium' => $medium,
        ];
    }
}