<?php

if (!function_exists('env')) {
    function env(string $key, mixed $default = null): mixed
    {
        return $_ENV[$key] ?? $_SERVER[$key] ?? $default;
    }
}

if (!function_exists('config')) {
    function config(string $key, mixed $default = null): mixed
    {
        return App\Core\App::config($key, $default);
    }
}

if (!function_exists('view')) {
    function view(string $template, array $data = [], ?string $layout = 'layouts.app'): App\Core\View
    {
        $basePath = realpath(__DIR__ . '/../resources/views');
        $templatePath = $basePath . '/' . str_replace('.', '/', $template) . '.php';

        $view = new App\Core\View($templatePath, $data, $basePath);

        if ($layout !== null) {
            $view->setLayout($layout);
        }

        return $view;
    }
}

if (!function_exists('redirect')) {
    function redirect(string $to, int $status = 302): App\Core\Response
    {
        return new App\Core\Response('', $status, ['Location' => $to]);
    }
}

if (!function_exists('session')) {
    function session(): App\Core\Session
    {
        return App\Core\Session::instance();
    }
}

if (!function_exists('str_slug')) {
    function str_slug(string $value, string $separator = '-'): string
    {
        $value = strtolower($value);
        $value = preg_replace('/[^a-z0-9]+/i', $separator, $value);
        $value = trim($value, $separator);

        return $value ?: uniqid();
    }
}
