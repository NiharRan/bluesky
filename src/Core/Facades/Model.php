<?php

namespace Bluesky\Core\Facades;

class Model extends Facade
{
    public static function __callStatic(string $method, array $arguments)
    {
        $modelName = get_called_class();
        $model = new $modelName();
        $table = $model->table;
        self::resolveFacade('model')->setTable($table);

        $primaryKey = $model->primaryKey;
        self::resolveFacade('model')->setPrimaryKey($primaryKey);
        
        return self::resolveFacade('model')->$method(...$arguments);
    }
}