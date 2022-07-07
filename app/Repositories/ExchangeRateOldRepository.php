<?php

namespace App\Repositories;

use App\Models\ExchangeRateOld;

class ExchangeRateOldRepository extends BaseRepository
{
    public function getModel()
    {
        return ExchangeRateOld::class;
    }

    public function getByUnit($unit)
    {
        return $this->model->where(ExchangeRateOld::COL_UNIT, removeAccent($unit))->first();
    }
}