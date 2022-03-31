<?php

namespace Bluesky\Core\Orm;

use Bluesky\Core\Facades\Facade;
use Bluesky\Core\Orm\Traits\ModelBuilderHelper;
use Bluesky\Core\Orm\Traits\ModelRelation;
use Exception;
use ReflectionClass;

class Model
{
    use ModelBuilderHelper, ModelRelation;
    
    protected string $table;
    protected array $fillable;
    protected string $primaryKey;

    public function __construct()
    {
        
    }

    public function __set(string $key, $value): void
    {
        if (!isset($this->fillable[$key])) {
            throw new Exception("Invalid veriable", 1);
        }
        $this->fillable[$key] = $value;
    }

    public function setTable($table)
    {
        $this->table = $table;
    }
    public function setPrimaryKey($primaryKey)
    {
        $this->primaryKey = $primaryKey;
    }

    public function __get(string $name)
    {
        if($name == 'table') {
            return $this->table;
        }
        return $this->fillable[$name] ?? null;
    }

    public static function __callStatic(string $method, array $arguments)
    {
        $modelName = get_called_class();
        $model = new $modelName();
        $resolver = Facade::resolveFacade('builder');
        $reflaction = new ReflectionClass($modelName);
        $props = $reflaction->getProperties();
        foreach ($props as $prop) {
            $name = $prop->getName();
            $resolver->{$name} = $model->{$name};
        }

        $resolver->model = $model;
        return $resolver->$method(...$arguments);
    }
}