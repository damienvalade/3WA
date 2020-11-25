<?php

namespace Twitter\Http;

class Request
{
    protected array $data = [];

    public function __Construct(array $data = [])
    {
        $this->data = $data;
    }

    public function get(string $name, $default = null)
    {
        return $this->data[$name] ?? $default;
    }
}