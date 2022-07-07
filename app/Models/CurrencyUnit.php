<?php

namespace App\Models;


class CurrencyUnit extends BaseModel
{
    protected $fillable = [
        'unit',
        'name',
        'time_created'
    ];

    const COL_UNIT = 'unit';
    const COL_NAME = 'name';

    public function getColUnit()
    {
        return $this->{$this::COL_UNIT};
    }

    public function getColName()
    {
        return $this->{$this::COL_NAME};
    }

    public function isChangeName($name)
    {
        return $this->getColName() != $name;
    }
}
