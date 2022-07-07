<?php

namespace App\Helpers\Caches;

use Illuminate\Support\Facades\Cache;
use App\Repositories\ExchangeRateOldRepository;

class ExchangeRateOldCache
{
    public static function cache($exchange_rate)
    {
        if(config('cache.default') == 'redis') {
            Cache::put('exchange_rate_old:'. $exchange_rate->getColUnit(), $exchange_rate);
        }
    }

    public static function get($unit)
    {
        $unit = removeAccent($unit);
        $data = null;
        if(config('cache.default') == 'redis') {
            $data = Cache::get("exchange_rate_old:$unit");
        }

        if(!$data){
            $data = self::getDB($unit);
        }

        if($data && $data->isCallNewRate(UNIT_DEFAUT, NUMBER_DATE_SAVE_RATES)) {
            $data = null;
        }

        return $data;
    }

    public static function getDB($unit)
    {
        $unit = removeAccent($unit);
        $data = (new ExchangeRateOldRepository)->getByUnit($unit);
        
        if(!$data){
            return null;
        }
        
        self::cache($data);
        return $data;
    }
}