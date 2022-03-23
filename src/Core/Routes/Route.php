<?php

namespace Bluesky\Core\Routes;

class Route extends Router
{
    protected string $namespace = '\Bluesky\Controllers';
    public string $controller;
    public string $method;
    public string $uri;
    public string $verb;
    public array $params;
    public string $name;
    public array $parts;
    public array $paramPositions;

    public function __construct($uri, $verb, $actions = null)
    {
        $this->uri = $uri;
        $this->verb = $verb;
        $this->parts = explode('/', $uri);
        $this->paramPositions = $this->getAllParamPositions($this->parts);
        if ($this->isControllerCallable($actions)) {
            $this->readyController($actions);
        }
    }

    private function getAllParamPositions(array $parts): array
    {
        $positions = [];
        foreach ($parts as $key => $part) {
            if (str_starts_with($part, ':')) {
                $positions[] = $key;
            }
        }

        return $positions;
    }

    public function readyController($actions)
    {
        $params = explode('@', $actions);
        $this->controller = $params[0];
        $this->method = $params[1];
    }

    public function runController(array $parts)
    {
        $controller = $this->resolveController();
        return (new $controller())->{$this->method}(...$parts);
    }

    protected function resolveController(): string
    {
        return  "$this->namespace\\$this->controller";
    }

    protected function isControllerCallable(string $actions): bool
    {
        if (is_string($actions) && strpos($actions, '@')) {
            return true;
        }
        return false;
    }

    public function setName(string $routeName)
    {
        $this->name = $routeName;
        preg_match_all('/:\w+/', $this->uri, $matches);
        if (count($matches) > 0) {
            $this->params = $matches;
        }
    }

    protected function isTargetRoute(array $parts): ?Route
    {
        $flag = true;
        foreach ($parts as $key => $part) {
            if (!in_array($key, $this->paramPositions)) {
                if ($part != $this->parts[$key]) {
                    $flag = false;
                }
            }
        }
        return $flag ? $this : null;
    }

    public function hasName($name)
    {
        return $this->name == $name;
    }

    protected function setParts(array $parts)
    {
        foreach ($this->paramPositions as $position) {
            $this->parts[$position] = $parts[$position];
        }
    }

    public function getParts(): array
    {
        $parts = [];
        foreach ($this->paramPositions as $position) {
            $parts[] = $this->parts[$position];
        }

        return $parts;
    }
}