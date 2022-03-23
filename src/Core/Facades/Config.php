<?php

namespace Bluesky\Core\Facades;

class Config extends Facade
{
    public static function __callStatic(string $method, array $arguments)
    {
        return self::resolveFacade('config')->$method(...$arguments);
    }
}