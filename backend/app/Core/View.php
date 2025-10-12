<?php

namespace App\Core;

class View
{
    protected ?string $layout;
    protected string $basePath;

    public function __construct(
        protected string $template,
        protected array $data = [],
        string $basePath = '',
        ?string $layout = null
    ) {
        $this->basePath = $basePath !== '' ? $basePath : dirname($this->template);
        $this->layout = $layout;
    }

    public function setLayout(?string $layout): void
    {
        $this->layout = $layout;
    }

    public function render(): string
    {
        $content = $this->renderFile($this->template, $this->data);

        if ($this->layout) {
            $layoutPath = $this->resolveViewPath($this->layout);
            $layoutData = array_merge($this->data, ['content' => $content]);

            return $this->renderFile($layoutPath, $layoutData);
        }

        return $content;
    }

    protected function renderFile(string $path, array $data): string
    {
        extract($data, EXTR_SKIP);

        ob_start();
        require $path;

        return (string) ob_get_clean();
    }

    protected function resolveViewPath(string $dotPath): string
    {
        $normalized = str_replace('.', '/', $dotPath);
        return rtrim($this->basePath, '/\\') . '/' . ltrim($normalized, '/\\') . '.php';
    }
}
