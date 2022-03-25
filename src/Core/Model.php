<?php

namespace Bluesky\Core;

use Bluesky\Core\Traits\ModelBuilder;
use Bluesky\Core\Traits\ModelBuilderHelper;
use Exception;

class Model 
{
    use ModelBuilder, ModelBuilderHelper;
    
    protected array $whereBlocks;
    protected array $selects;
    protected array $with;
    protected string $sqlQuery;
    protected string $table;
    protected array $fillable;
    protected string $primaryKey;

    public function __construct()
    {
        $this->whereBlocks = [];
        $this->sqlQuery = '';
        $this->table = '';
        $this->fillable = [];
        $this->primaryKey = 'id';
        $this->selects = [];
        $this->with = [];
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
}