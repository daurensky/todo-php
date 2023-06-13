<?php

namespace App\Lib;

class Url
{
    private string $path;
    private array  $params = [];

    public function __construct(?string $url = null)
    {
        $urlParts = parse_url($url ?? $_SERVER['REQUEST_URI']);
        $this->path = $urlParts['path'];

        if (isset($urlParts['query'])) {
            parse_str($urlParts['query'], $this->params);
        }
    }

    public function withParams(array $params): static
    {
        foreach ($params as $key => $value) {
            $this->params[$key] = $value;
        }
        return $this;
    }

    public function __toString(): string
    {
        if (count($this->params) > 0) {
            return $this->path . '?' . http_build_query($this->params);
        }
        return $this->path;
    }
}
