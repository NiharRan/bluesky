<?php

namespace Bluesky\Core;

class Request
{
    private array $params;
    public function __construct()
    {
        $this->params = [];
    }

    public function setParams(array $params): void
    {
        $customized = [];
        foreach ($params as $param) {
            $parts = explode('=', $param);
            $customized[$parts[0]] = $parts[1];
        }
        $this->params = array_merge($this->params, $customized);
    }

    public function __get(string $name): ?string
    {
        return $this->params[$name] ?? null;
    }

    public function __set(string $name, $value): void
    {
        $this->params[$name] = $value;
    }

    public function all(): array
    {
        return $this->params;
    }

    public function get(string $name, $value = null)
    {
        return $this->params[$name] ?? $value;
    }
}