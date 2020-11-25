<?php

namespace Twitter\Controller;

use Twitter\Http\Request;
use Twitter\Http\Response;

class HelloController
{
    /**
     * @param Request $request
     * @return Response
     */
    public function sayHello(Request $request)
    {
        $name = $request->get('name', 'World');

        $response = new Response();
        $response->setStatusCode(200);
        $response->setHeaders([
            'Content-Type' => 'text/html',
            'Lang' => 'fr-FR'
        ]);

        $response->setContent("Hello $name");
        return $response;
    }
}