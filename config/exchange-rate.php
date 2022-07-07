<?php

return [
    'api_key' => env('EXCHANGE_RATES_API_KEY', 'null'),
    'api_url' => env('EXCHANGE_RATES_API_URL', 'https://api.apilayer.com/exchangerates_data'),
    'prefix_url_latest' => env('EXCHANGE_RATES_PREFIX_LATEST', 'latest'),
    'prefix_url_date' => env('EXCHANGE_RATES_PREFIX_DATE', 'date'),
    'prefix_url_timeseries' => env('EXCHANGE_RATES_PREFIX_TIMESERIES', 'timeseries'),
];
