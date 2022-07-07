<?php

namespace App\Repositories;

use App\Models\ExchangeRateNow;

class ExchangeRateNowRepository extends BaseRepository
{
    public function getModel()
    {
        return ExchangeRateNow::class;
    }

    public function getByUnit($unit)
    {
        return $this->model->where(ExchangeRateNow::COL_UNIT, removeAccent($unit))->first();
    }
}