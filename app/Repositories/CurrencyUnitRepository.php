<?php

namespace App\Repositories;

use App\Models\CurrencyUnit;

class CurrencyUnitRepository extends BaseRepository
{
    public function getModel()
    {
        return CurrencyUnit::class;
    }

    public function getByUnit($unit)
    {
        return $this->model->where(CurrencyUnit::COL_UNIT, removeAccent($unit))->first();
    }
}