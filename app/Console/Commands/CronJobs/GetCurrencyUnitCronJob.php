<?php

namespace App\Console\Commands\CronJobs;

use Illuminate\Console\Command;
use App\Repositories\CurrencyUnitRepository;
use App\Models\CurrencyUnit;
use App\Helpers\Caches\CurrencyUnitCache;

class GetCurrencyUnitCronJob extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'exchange-make:get-currency-unit';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(CurrencyUnitRepository $model)
    {
        $url = 'https://openexchangerates.org/api/currencies.json';
        $units = json_decode(file_get_contents($url), true);

        foreach ($units as $key => $unit)
        {
            $params = [
                CurrencyUnit::COL_UNIT => removeAccent($key),
                CurrencyUnit::COL_NAME => $unit,
                
            ];

            $check_unit = $model->getByUnit($unit);

            if(!$check_unit) {
                $params[CurrencyUnit::COL_TIME_CREATED] = dateTime();

                $model->create($params);
            }else {
                if($check_unit->isChangeName()) {
                    $params[CurrencyUnit::COL_TIME_UPDATED] = dateTime();

                    $check_unit->update($params);
                }
            }
        }

        CurrencyUnitCache::cache();
    }
}
