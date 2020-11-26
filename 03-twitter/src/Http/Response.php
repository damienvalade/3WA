<?php


namespace Twitter\Http;

class Response
{
    protected int $statusCode;
    protected array $headers;
    protected string $content;

    public function __Construct
    (
        string $content = '',
        int $statusCode = 200,
        array $headers = []
    )
    {
        $this->content = $content;
        $this->statusCode = $statusCode;
        $this->headers= $headers;
    }

    public function send()
    {
        http_response_code($this->statusCode);
        foreach ($this->headers as $key => $value){
            header("$key: $value");
        }
        echo $this->content;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function setStatusCode(int $statusCode)
    {
        $this->statusCode = $statusCode;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function setHeaders(array $headers)
    {
        $this->headers = $headers;
    }

    public function getHeader(string $name): ?string
    {
        return $this->headers[$name] ?? null;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content)
    {
        $this->content = $content;
    }
}