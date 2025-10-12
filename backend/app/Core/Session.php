<?php

namespace App\Core;

class Session
{
    protected static ?self $instance = null;
    protected array $flash = [];
    protected array $old = [];

    public static function instance(): self
    {
        if (static::$instance === null) {
            static::$instance = new self();
        }

        return static::$instance;
    }

    protected function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->flash = $_SESSION['_flash'] ?? [];
        unset($_SESSION['_flash']);

        $this->old = $_SESSION['_old_input'] ?? [];
        unset($_SESSION['_old_input']);
    }

    public function flash(string $key, ?string $value = null): ?string
    {
        if ($value === null) {
            $message = $this->flash[$key] ?? null;
            unset($this->flash[$key]);
            return $message;
        }

        $_SESSION['_flash'][$key] = $value;
        return null;
    }

    public function hasFlash(string $key): bool
    {
        return array_key_exists($key, $this->flash);
    }

    public function allFlash(): array
    {
        return $this->flash;
    }

    public function setOldInput(array $data): void
    {
        $_SESSION['_old_input'] = $data;
    }

    public function old(string $key, mixed $default = null): mixed
    {
        return $this->old[$key] ?? $default;
    }

    public function oldInput(): array
    {
        return $this->old;
    }

    public function set(string $key, mixed $value): void
    {
        $_SESSION[$key] = $value;
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return $_SESSION[$key] ?? $default;
    }

    public function forget(string $key): void
    {
        unset($_SESSION[$key]);
    }

    public function regenerate(): void
    {
        session_regenerate_id(true);
    }

    public function flush(): void
    {
        $_SESSION = [];
    }

    public function destroy(): void
    {
        $this->flush();
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_destroy();
        }
    }
}
