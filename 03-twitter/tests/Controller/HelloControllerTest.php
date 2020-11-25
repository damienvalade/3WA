<?php

use PHPUnit\Framework\TestCase;
use Twitter\Http\Request;
use Twitter\Controller\HelloController;

class HelloControllerTest extends TestCase{

    public function testSayHelloWork()
    {
        $request = new Request([
            'name' => "Damien"
        ]);
        $controller = new HelloController();
        $response = $controller->sayHello($request);

        $this->assertEquals("Hello Damien", $response->getContent());
        $this->assertEquals(200, $response->getStatusCode());
        $headers = $response->getHeaders();
        $this->assertArrayHasKey('Content-Type', $headers);
        $this->assertArrayHasKey('Lang', $headers);
    }

    public function testSayHelloDontWork()
    {
        $request = new Request([]);

        $controller = new HelloController();
        $response = $controller->sayHello($request);

        $this->assertEquals("Hello World", $response->getContent());
        $this->assertEquals(200, $response->getStatusCode());
        $headers = $response->getHeaders();
        $this->assertArrayHasKey('Content-Type', $headers);
        $this->assertArrayHasKey('Lang', $headers);
    }
}