<?php

namespace Bluesky\Core\Facades;

class Router extends Facade
{
    public static function __callStatic(string $method, array $arguments)
    {
        return self::resolveFacade('router')->$method(...$arguments);
    }
}