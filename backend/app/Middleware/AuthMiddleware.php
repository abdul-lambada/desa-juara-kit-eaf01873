<?php

namespace App\Middleware;

use App\Core\Request;
use App\Core\Response;

class AuthMiddleware
{
    protected array $except;

    public function __construct(array $config = [])
    {
        $this->except = array_map(fn ($path) => rtrim($path, '/') ?: '/', $config['except'] ?? []);
    }

    public function handle(Request $request): ?Response
    {
        $uri = rtrim($request->uri(), '/') ?: '/';

        foreach ($this->except as $except) {
            if ($this->matches($except, $uri)) {
                return null;
            }
        }

        if (session()->get('auth')) {
            return null;
        }

        session()->flash('error', 'Silakan masuk terlebih dahulu.');
        return redirect('/auth/login');
    }

    protected function matches(string $pattern, string $uri): bool
    {
        if ($pattern === $uri) {
            return true;
        }

        if (str_contains($pattern, '*')) {
            $regex = '#^' . str_replace(['*', '/'], ['[^/]*', '\/'], $pattern) . '$#';
            return (bool) preg_match($regex, $uri);
        }

        return false;
    }
}
