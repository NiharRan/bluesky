<?php

namespace Bluesky\Core\Routes;

class Router
{
    protected array $routes;
    public static $verbs = ['GET', 'HEAD', 'POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS'];
    private string $currentVerb;
    private string $currentUri;
    public function __construct()
    {
        $this->routes = [];
    }

    public function get($uri, $actions = null) {
        $uri = $this->trimUri($uri);
        $this->routes['get'][$uri] = new Route($uri, 'get', $actions);
        $this->setCurrent('get', $uri);
        return $this;
    }
    public function head($uri, $actions = null) {
        $uri = $this->trimUri($uri);
        $this->routes['get'][$uri] = new Route($uri, 'get', $actions);
        $this->setCurrent('get', $uri);
        return $this;
    }

    public function post($uri, $actions = null) {
        $uri = $this->trimUri($uri);
        $this->routes['post'][$uri] = new Route($uri, 'post', $actions);
        $this->setCurrent('post', $uri);
        return $this;
    }

    public function put($uri, $actions = null) {
        $uri = $this->trimUri($uri);
        $this->routes['put'][$uri] = new Route($uri, 'put', $actions);
        $this->setCurrent('put', $uri);
        return $this;
    }
    public function patch($uri, $actions = null) {
        $uri = $this->trimUri($uri);
        $this->routes['put'][$uri] = new Route($uri, 'put', $actions);
        $this->setCurrent('put', $uri);
        return $this;
    }

    public function delete($uri, $actions = null) {
        $uri = $this->trimUri($uri);
        $this->routes['delete'][$uri] = new Route($uri, 'delete', $actions);
        $this->setCurrent('delete', $uri);
        return $this;
    }

    private function setCurrent($verb, $uri)
    {
        $this->currentVerb = $verb;
        $this->currentUri = $uri;
    }


    public function name($routeName)
    {
        $route = $this->getCurrentRoute();
        $route->setName($routeName);
        $this->setCurrentRoute($route);
    }

    public function getCurrentRoute()
    {
        return $this->routes[$this->currentVerb][$this->currentUri];
    }

    public function setCurrentRoute(Route $route)
    {
        $this->routes[$this->currentVerb][$this->currentUri] = $route;
    }

    public function getRouteByName($name)
    {
        foreach ($this->routes as $verb) {
            foreach ($verb as $route) {
                if ($route->hasName($name)) {
                    return $route->runController();
                }
            }
        }
    }

    public function getRouteByUri(string $uri, string $verb, array $params): ?Route
    {
        $parts = explode('/', ltrim(rtrim($uri, '/'), '/'));
        $routes = $this->getAllSameLengthRoutes($verb, count($parts) - 1);
        foreach ($routes as $key => $route) {
            $route = $route->isTargetRoute($parts);
            if ($route) {
                $route->setParts($parts);
            }
            return $route;
        }
    }

    public function validVerb(string $verb): bool
    {
        return in_array($verb, self::$verbs);
    }

    private function getAllSameLengthRoutes(string $verb, int $len): array
    {
        $routes = [];
        foreach ($this->routes[$verb] as $key => $route) {
            if (substr_count($key, '/') == $len) {
                $routes[$key] = $route;
            }
        }
        return $routes;
    }
    private function trimUri(string $uri): string
    {
        return ltrim(rtrim($uri, '/'), '/');
    }

    public function all()
    {
        dd($this->routes);
    }
}