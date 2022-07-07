<?php

namespace App\Helpers\Caches;

use Illuminate\Support\Facades\Cache;
use App\Repositories\ExchangeRateNowRepository;

class ExchangeRateNowCache
{
    public static function cache($exchange_rate_now)
    {
        if(config('cache.default') == 'redis') {
            Cache::put('exchange_rate_now:'. $exchange_rate_now->getColUnit(), $exchange_rate_now);
        }
    }

    public static function get($unit)
    {
        $unit = removeAccent($unit);
        $data = null;
        if(config('cache.default') == 'redis') {
            $data = Cache::get("exchange_rate_now:$unit");
        }

        if(!$data){
            $data = self::getDB($unit);
        }

        if($data && $data->isCallNewRate(UNIT_DEFAUT)) {
            $data = null;
        }

        return $data;
    }

    public static function getDB($unit)
    {
        $unit = removeAccent($unit);
        $data = (new ExchangeRateNowRepository)->getByUnit($unit);
        
        if(!$data){
            return null;
        }
        
        self::cache($data);
        return $data;
    }
}