<?php

namespace Bluesky\Core\Orm\Traits;

use Bluesky\Core\Orm\Model;
use Closure;

/**
 * 
 */
trait ModelBuilder
{
    public function select(...$fields)
    {
        $this->selects = array_merge($this->selects, $fields);
        return $this;
    }

    public function where(...$params): Model
    {
        $size = count($params);
        if ($size > 1 && $size < 4) {
            $this->generateField($params);
            return $this;
        }

        $params = $params[0];
        if (is_array($params)) {
            if (isAssociativeArray($params)) {
                foreach ($params as $key => $value) {
                    $this->whereBlocks[] = ['AND', $key, '=', $value];
                }
            } else {
                foreach ($params as $key => $param) {
                    $size = count($param);
                    if ($size > 1 && $size < 4) {
                        $this->generateField($param);
                    }
                }
            }
            return $this;
        }

        if ($this->paramHasCallback($params)) {
            $this->whereBlocks[] = ['AND', '(', '', ''];
            $params($this);
            $this->whereBlocks[] = ['AND', '', '', ')'];
        }

        return $this;
    }

    public function orWhere(...$params): Model
    {
        $size = count($params);
        if ($size > 1 && $size < 4) {
            $this->generateField($params, 'OR');
            return $this;
        }

        $params = $params[0];
        if (is_array($params)) {
            if (isAssociativeArray($params)) {
                foreach ($params as $key => $value) {
                    $this->whereBlocks[] = ['OR', $key, '=', $value];
                }
            } else {
                foreach ($params as $key => $param) {
                    $size = count($param);
                    if ($size > 1 && $size < 4) {
                        $this->generateField($param, 'OR');
                    }
                }
            }
            return $this;
        }

        if ($this->paramHasCallback($params)) {
            $this->whereBlocks[] = ['OR', '(', '', ''];
            $params($this);
            $this->whereBlocks[] = ['OR', '', '', ')'];
        }

        return $this;
    }

    public function paramHasCallback($param)
    {
        return $param instanceof Closure;
    }

    public function getSql()
    {
        return $this->sqlQuery;
    }

    public function get()
    {
        $this->buildQuery();
        return $this;
    }
}
