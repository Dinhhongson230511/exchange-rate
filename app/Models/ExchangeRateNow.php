<?php

namespace App\Models;


class ExchangeRateNow extends BaseModel
{
    protected $fillable = [
        'unit', 
        'base',
        'rate',
        'time_created',
        'time_updated',
    ];

    const COL_UNIT = 'unit';
    const COL_BASE = 'base';
    const COL_RATE = 'rate';

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

    public function isCallNewRate($base_now)
    {
        return $this->getColBase() != removeAccent($base_now);
    }
}
