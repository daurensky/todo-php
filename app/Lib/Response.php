<?php

namespace App\Lib;

class Response
{
    private int   $code    = 200;
    private array $headers = [];
    private array $olds    = [];

    public function __construct(
        protected readonly ?string $message,
    ) {}

    public function withHeaders(array $headers): static
    {
        $this->headers = $headers;
        return $this;
    }

    public function withCode(int $code): static
    {
        $this->code = $code;
        return $this;
    }

    public function withOlds(array $olds): static
    {
        $this->olds = $olds;
        return $this;
    }

    public function handle(): void
    {
        http_response_code($this->code);

        foreach ($this->headers as $header) {
            header($header);
        }

        foreach ($this->olds as $field => $value) {
            $_SESSION['flash']['old'][$field] = $value;
        }

        if ($this->message) {
            echo $this->message;
        }
    }
}
