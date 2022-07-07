<?php

namespace App\Models;


class ExchangeRateOld extends BaseModel
{
    protected $casts = [
        'date_update' => 'date:Y-m-d',
    ];

    protected $fillable = [
        'unit',
        'base',
        'rate',
        'rate_date', 
        'number_rate', 
        'date_update',
        'time_created',
        'time_updated',
    ];

    const COL_UNIT = 'unit';
    const COL_BASE = 'base';
    const COL_RATE = 'rate';
    const COL_RATE_DATE = 'rate_date';
    const COL_NUMBER_RATE = 'number_rate';
    const COL_DATE_UPDATE = 'date_update';

    public function getColUnit()
    {
        return $this->{$this::COL_UNIT};
    }
    public function getColBase()
    {
        return $this->{$this::COL_BASE};
    }
    public function getColRate()
    {
        return (float)$this->{$this::COL_RATE};
    }
    public function getColDateUpdate()
    {
        return $this->{$this::COL_DATE_UPDATE};
    }
    public function getColNumberRate()
    {
        return (int)$this->{$this::COL_NUMBER_RATE};
    }

    public function isCallNewRate($base_now, $number_day_save)
    {
        if($this->getColBase() != $base_now) return true;
        if($this->getColNumberRate() != $number_day_save) return true;

        if($this->getColDateUpdate() != getDay()) return true;

        return false;
    }
}
