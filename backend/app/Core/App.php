<?php

namespace App\Core;

use App\Middleware\AuthMiddleware;
use Dotenv\Dotenv;

class App
{
    protected static ?App $instance = null;
    protected static array $config = [];

    protected Router $router;
    protected Database $database;
    protected array $middleware = [];

    public static function init(): self
    {
        if (static::$instance instanceof App) {
            return static::$instance;
        }

        $basePath = realpath(__DIR__ . '/../../');

        if (file_exists($basePath . '/.env')) {
            $dotenv = Dotenv::createImmutable($basePath);
            $dotenv->load();
        }

        foreach (glob($basePath . '/config/*.php') as $configFile) {
            $key = basename($configFile, '.php');
            static::$config[$key] = require $configFile;
        }

        date_default_timezone_set(static::$config['app']['timezone'] ?? 'UTC');

        $database = new Database(static::$config['database']);
        $router = new Router($database);

        static::$instance = new self($router, $database);

        $authGuardConfig = static::$config['auth']['guard'] ?? [];
        static::$instance->registerMiddleware(new AuthMiddleware($authGuardConfig));

        return static::$instance;
    }

    public static function config(string $key, mixed $default = null): mixed
    {
        $segments = explode('.', $key);
        $value = static::$config;

        foreach ($segments as $segment) {
            if (!is_array($value) || !array_key_exists($segment, $value)) {
                return $default;
            }
            $value = $value[$segment];
        }

        return $value;
    }

    public function router(): Router
    {
        return $this->router;
    }

    public function database(): Database
    {
        return $this->database;
    }

    public function run(): void
    {
        $request = new Request();

        foreach ($this->middleware as $middleware) {
            $response = null;

            if (is_callable($middleware)) {
                $response = $middleware($request);
            } elseif (is_object($middleware) && method_exists($middleware, 'handle')) {
                $response = $middleware->handle($request);
            }

            if ($response instanceof Response) {
                $response->send();
                return;
            }

            if ($response instanceof View) {
                echo $response->render();
                return;
            }

            if (is_string($response)) {
                echo $response;
                return;
            }

            if ($response !== null) {
                header('Content-Type: application/json');
                echo json_encode($response);
                return;
            }
        }

        $response = $this->router->dispatch($request, $this->database);

        if ($response instanceof Response) {
            $response->send();
            return;
        }

        if ($response instanceof View) {
            echo $response->render();
            return;
        }

        if (is_string($response)) {
            echo $response;
            return;
        }

        if ($response !== null) {
            header('Content-Type: application/json');
            echo json_encode($response);
        }
    }

    protected function __construct(Router $router, Database $database)
    {
        $this->router = $router;
        $this->database = $database;
    }

    public function registerMiddleware(callable|object $middleware): void
    {
        $this->middleware[] = $middleware;
    }
}
