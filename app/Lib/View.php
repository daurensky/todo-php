<?php

namespace App\Lib;

class View
{
    private array $variables = [];

    public function __construct(
        private readonly string $name,
    ) {}

    public function withVariables(array $variables): static
    {
        // Prevent XSS attack
        array_walk_recursive(
            $variables,
            fn(&$value) => $value !== null ? $value = htmlentities($value) : $value,
        );
        $this->variables = $variables;
        return $this;
    }

    public function render(): void
    {
        extract($this->variables);
        require_once root_dir("views/{$this->name}.php");
    }
}
