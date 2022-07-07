<?php

namespace App\Observers;

use App\Models\ExchangeRateNow;
use App\Helpers\Caches\ExchangeRateNowCache;

class ExchangeRateNowObserver
{
    /**
     * Handle the ExchangeRateNow "created" event.
     *
     * @param  \App\Models\ExchangeRateNow  $exchangeRateNow
     * @return void
     */
    public function created(ExchangeRateNow $exchangeRateNow)
    {
        ExchangeRateNowCache::cache($exchangeRateNow);
    }

    /**
     * Handle the ExchangeRateNow "updated" event.
     *
     * @param  \App\Models\ExchangeRateNow  $exchangeRateNow
     * @return void
     */
    public function updated(ExchangeRateNow $exchangeRateNow)
    {
        ExchangeRateNowCache::cache($exchangeRateNow);
    }

    /**
     * Handle the ExchangeRateNow "deleted" event.
     *
     * @param  \App\Models\ExchangeRateNow  $exchangeRateNow
     * @return void
     */
    public function deleted(ExchangeRateNow $exchangeRateNow)
    {
        //
    }

    /**
     * Handle the ExchangeRateNow "restored" event.
     *
     * @param  \App\Models\ExchangeRateNow  $exchangeRateNow
     * @return void
     */
    public function restored(ExchangeRateNow $exchangeRateNow)
    {
        //
    }

    /**
     * Handle the ExchangeRateNow "force deleted" event.
     *
     * @param  \App\Models\ExchangeRateNow  $exchangeRateNow
     * @return void
     */
    public function forceDeleted(ExchangeRateNow $exchangeRateNow)
    {
        //
    }
}
