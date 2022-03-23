<?php

use \Bluesky\Core\Application;

if (!function_exists('getFileName')) {
    function getFileName($path) {
        $file = basename($path);
        $ext = pathinfo($file, PATHINFO_EXTENSION);

        return str_replace(".$ext", '', $file);
    }
}

if (!function_exists('app')) {
    function app($params = null) {
        if (!$params) {
            return Application::init();
        }

        if (is_array($params)) {
            $arr = [];
            foreach ($params as $param) {
                $arr[] = Application::init()->{$params};
            }
            return $arr;
        }
        return Application::init()->{$params};
    }
}

if (!function_exists('response')) {
    function response() {
        return app()->response;
    }
}


if (!function_exists('route')) {
    function route($name, $params) {
        $router = app('router');
        $route = $router->getRouteByName($name);
        $uri = $route->uri;
        $routeParams = $route->params;
        if (is_array($params)) {
            if (count($params) != count($routeParams)) {
                throw new Exception('Route parameter miss-match');
            }
            foreach ($routeParams as $key => $match) {
                $uri = str_replace($match, $params[$key], $uri);
            }
        } else {
            $uri = str_replace($routeParams[0], $params, $uri);
        }
    }
}


if (!function_exists('env')) {
    function env($key, $value = '') {
        if (!isset($_ENV[$key])) {
            return $value;
        }
        return $_ENV[$key];
    }
}