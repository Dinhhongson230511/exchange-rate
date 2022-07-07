<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

use App\Models\ExchangeRateNow;
use App\Observers\ExchangeRateNowObserver;
use App\Models\ExchangeRateOld;
use App\Observers\ExchangeRateOldObserver;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        ExchangeRateNow::observe(ExchangeRateNowObserver::class);
        ExchangeRateOld::observe(ExchangeRateOldObserver::class);
    }
}
