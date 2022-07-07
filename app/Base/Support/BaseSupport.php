<?php
namespace App\Base\Support;

abstract class BaseSupport
{
    /**
     * __construct
     *
     * @return self
     */
    final public function __construct()
    {
        return $this;
    }

    /**
     * Handle dynamic static method calls into the model.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     */
    public static function __callStatic($method, $parameters)
    {
        return (new static )->$method(...$parameters);
    }
}
