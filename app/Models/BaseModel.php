<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BaseModel extends Model
{
    use SoftDeletes;
    protected $connection = 'mysql';
    public $timestamps  = false;
    const COL_TIME_CREATED = 'time_created';
    const COL_TIME_UPDATED = 'time_updated';
    const COL_DELETED_AT = 'deleted_at';
    
    protected $casts = [
        'time_created' => 'date:Y-m-d H:i:s',
        'time_updated' => 'date:Y-m-d H:i:s',
        'deleted_at' => 'date:Y-m-d H:i:s',
    ];
}
