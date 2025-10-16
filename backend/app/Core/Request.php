<?php

namespace App\Core;

class Request
{
    protected array $routeParams = [];

    public function method(): string
    {
        $method = strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET');

        if ($method === 'POST' && isset($_POST['_method'])) {
            $spoofed = strtoupper($_POST['_method']);

            if (in_array($spoofed, ['PUT', 'PATCH', 'DELETE'], true)) {
                $method = $spoofed;
            }
        }

        return $method;
    }

    public function uri(): string
    {
        $requestUri = $_SERVER['REQUEST_URI'] ?? '/';
        $path = parse_url($requestUri, PHP_URL_PATH) ?: '/';

        $scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
        $basePath = rtrim(str_replace('\\', '/', dirname($scriptName)), '/');

        if ($basePath !== '' && str_starts_with($path, $basePath)) {
            $path = substr($path, strlen($basePath));
        }

        $appUrl = (string) config('app.url', '');
        $appUrlPath = rtrim(parse_url($appUrl, PHP_URL_PATH) ?: '', '/');

        if ($appUrlPath !== '' && str_starts_with($path, $appUrlPath . '/')) {
            $path = substr($path, strlen($appUrlPath));
        } elseif ($appUrlPath !== '' && $path === $appUrlPath) {
            $path = '/';
        }

        if ($appUrlPath !== '') {
            $altPath = rtrim(str_replace('/public', '', $appUrlPath), '/');
            if ($altPath !== '' && str_starts_with($path, $altPath . '/')) {
                $path = substr($path, strlen($altPath));
            } elseif ($altPath !== '' && $path === $altPath) {
                $path = '/';
            }

            $segments = array_filter(explode('/', $altPath));
            if (!empty($segments)) {
                $alias = '/' . end($segments);
                if (str_starts_with($path, $alias . '/')) {
                    $path = substr($path, strlen($alias));
                } elseif ($path === $alias) {
                    $path = '/';
                }
            }
        }

        $normalized = '/' . ltrim($path, '/');

        return $normalized === '//' ? '/' : $normalized;
    }

    public function input(string $key, mixed $default = null): mixed
    {
        return $_REQUEST[$key] ?? $default;
    }

    public function all(): array
    {
        return $_REQUEST;
    }

    public function only(array $keys): array
    {
        return array_intersect_key($this->all(), array_flip($keys));
    }

    public function has(string $key): bool
    {
        return array_key_exists($key, $this->all());
    }

    public function setRouteParams(array $params): void
    {
        $this->routeParams = $params;
    }

    public function route(string $key, mixed $default = null): mixed
    {
        return $this->routeParams[$key] ?? $default;
    }

    public function routeParams(): array
    {
        return $this->routeParams;
    }
}
