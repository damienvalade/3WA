<?php


namespace Twitter\Controller;


use Twitter\Http\Response;

class Controller
{
    protected function render($path, array $variables = [])
    {
        extract($variables);

        ob_start();
        require_once(__DIR__ . "/../../templates/" . $path);
        return new Response(ob_get_clean());
    }

    protected function redirect(string $url)
    {
        return new Response('', 302, [
            'Location' => $url
        ]);
    }
}