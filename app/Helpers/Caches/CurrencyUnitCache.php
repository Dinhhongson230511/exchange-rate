<?php

namespace App\Helpers\Caches;

use Illuminate\Support\Facades\Cache;
use App\Repositories\CurrencyUnitRepository;

class CurrencyUnitCache
{
    public static function getDB()
    {
        $currency_units = (new CurrencyUnitRepository)->getAll();

        $units = [];

        foreach ($currency_units as $unit) {
            $currency_unit = $unit->getColUnit();
            if(in_array($currency_unit, $units)) continue;
            $units[] = $currency_unit;
        }

        return $units;
    }

    public static function cache()
    {
        $units = self::getDB();
        if(config('cache.default') == 'redis') {
            Cache::forever('units', $units);
        }
    }

    public static function get()
    {
        if(config('cache.default') == 'redis') {
            $units = Cache::get('units');
            if($units) return $units;
        }
        return self::getDB();
    }

    public static function checkIsExist($unit)
    {
        $units = self::get();

        $unit = removeAccent($unit);

        return in_array($unit, $units);
    }
}