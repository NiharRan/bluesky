<?php

namespace Bluesky\Core\Facades;

class Facade
{
    public static function resolveFacade($name, $param = null)
    {
        return app($name, $param);
    }
}