<?php

namespace Bluesky\Core;

use Bluesky\Core\Orm\Builder;
use Bluesky\Core\Routes\Router;

class Application
{
    public Config $config;
    public Router $router;
    private static ?Application $application = null;
    public Controller $controller;
    public Response $response;
    public Request $request;
    public Builder $builder;

    public function __construct()
    {
        $this->config = new Config();
        $this->router = new Router();
        $this->controller = new Controller();
        $this->response = new Response();
        $this->request = new Request();
        $this->builder = new Builder();
    }

    public static function init()
    {
        if (null == self::$application) {
            self::$application = new Application();
        }
        return self::$application;
    }

    public function resolveRequest()
    {
        $uri = $this->getUri();
        $verb = $this->getMethod();
        $params = $this->getParams();

        if ($this->router->validVerb($verb)) {
            $verb = strtolower($verb);
            $route = $this->router->getRouteByUri($uri, $verb, $params);
            if ($route) {
                if (count($params) > 0) {
                    $this->request->setParams($params);
                }
                $parts = $route->getParts();
                $parts = array_merge([$this->request], $parts);
                echo $route->runController($parts);
            }
        }
    }

    private function getUri(): string
    {
        return urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
    }

    private function getMethod(): string
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    private function getParams(): array
    {
        return empty($_SERVER['QUERY_STRING']) ? [] : explode('&', str_replace('&&', '&', $_SERVER['QUERY_STRING']));
    }
}