<?php

namespace App\Core;

use Closure;
use RuntimeException;

class Router
{
    protected array $routes = [];

    public function __construct(protected Database $database)
    {
    }

    public function get(string $uri, callable|array $action): void
    {
        $this->addRoute('GET', $uri, $action);
    }

    public function post(string $uri, callable|array $action): void
    {
        $this->addRoute('POST', $uri, $action);
    }

    public function put(string $uri, callable|array $action): void
    {
        $this->addRoute('PUT', $uri, $action);
    }

    public function patch(string $uri, callable|array $action): void
    {
        $this->addRoute('PATCH', $uri, $action);
    }

    public function delete(string $uri, callable|array $action): void
    {
        $this->addRoute('DELETE', $uri, $action);
    }

    public function resource(string $uri, string $controller): void
    {
        $uri = trim($uri, '/');

        $this->get($uri, [$controller, 'index']);
        $this->get("{$uri}/create", [$controller, 'create']);
        $this->post($uri, [$controller, 'store']);
        $this->get("{$uri}/{id}", [$controller, 'show']);
        $this->get("{$uri}/{id}/edit", [$controller, 'edit']);
        $this->put("{$uri}/{id}", [$controller, 'update']);
        $this->delete("{$uri}/{id}", [$controller, 'destroy']);
    }

    public function addRoute(string $method, string $uri, callable|array $action): void
    {
        $uri = '/' . trim($uri, '/');
        $this->routes[$method][$uri] = $action;
    }

    public function dispatch(Request $request, Database $database): mixed
    {
        $method = $request->method();
        $uri = $request->uri();

        [$action, $params] = $this->matchRoute($method, $uri);

        if (!$action) {
            http_response_code(404);
            return 'Halaman tidak ditemukan';
        }

        if ($action instanceof Closure) {
            $request->setRouteParams($params);
            return $action($request, new Response(''));
        }

        if (is_array($action)) {
            $controller = $action[0] ?? null;
            $methodName = $action[1] ?? null;

            if (!$controller || !$methodName) {
                throw new RuntimeException('Rute controller harus berupa [Controller::class, "method"].');
            }

            if (!class_exists($controller)) {
                throw new RuntimeException("Controller {$controller} tidak ditemukan.");
            }

            $request->setRouteParams($params);
            $instance = new $controller($request, $database);

            if (!method_exists($instance, $methodName)) {
                throw new RuntimeException("Method {$methodName} tidak ditemukan pada {$controller}.");
            }

            return $instance->{$methodName}();
        }

        if (is_callable($action)) {
            $request->setRouteParams($params);
            return $action($request, $database);
        }

        throw new RuntimeException('Action tidak valid.');
    }

    protected function matchRoute(string $method, string $uri): array
    {
        $routes = $this->routes[$method] ?? [];

        if (isset($routes[$uri])) {
            return [$routes[$uri], []];
        }

        foreach ($routes as $routeUri => $action) {
            if (!str_contains($routeUri, '{')) {
                continue;
            }

            $pattern = preg_replace('#\{([^/]+)\}#', '(?P<$1>[^/]+)', $routeUri);
            $pattern = '#^' . $pattern . '$#';

            if (preg_match($pattern, $uri, $matches)) {
                $params = array_filter($matches, fn ($key) => !is_int($key), ARRAY_FILTER_USE_KEY);
                return [$action, $params];
            }
        }

        return [null, []];
    }
}
