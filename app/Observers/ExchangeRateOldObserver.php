<?php

namespace App\Observers;

use App\Models\ExchangeRateOld;
use App\Helpers\Caches\ExchangeRateOldCache;

class ExchangeRateOldObserver
{
    /**
     * Handle the ExchangeRateOld "created" event.
     *
     * @param  \App\Models\ExchangeRateOld  $ExchangeRateOld
     * @return void
     */
    public function created(ExchangeRateOld $ExchangeRateOld)
    {
        ExchangeRateOldCache::cache($ExchangeRateOld);
    }

    /**
     * Handle the ExchangeRateOld "updated" event.
     *
     * @param  \App\Models\ExchangeRateOld  $ExchangeRateOld
     * @return void
     */
    public function updated(ExchangeRateOld $ExchangeRateOld)
    {
        ExchangeRateOldCache::cache($ExchangeRateOld);
    }

    /**
     * Handle the ExchangeRateOld "deleted" event.
     *
     * @param  \App\Models\ExchangeRateOld  $ExchangeRateOld
     * @return void
     */
    public function deleted(ExchangeRateOld $ExchangeRateOld)
    {
        //
    }

    /**
     * Handle the ExchangeRateOld "restored" event.
     *
     * @param  \App\Models\ExchangeRateOld  $ExchangeRateOld
     * @return void
     */
    public function restored(ExchangeRateOld $ExchangeRateOld)
    {
        //
    }

    /**
     * Handle the ExchangeRateOld "force deleted" event.
     *
     * @param  \App\Models\ExchangeRateOld  $ExchangeRateOld
     * @return void
     */
    public function forceDeleted(ExchangeRateOld $ExchangeRateOld)
    {
        //
    }
}
