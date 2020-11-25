<?php

use PHPUnit\Framework\TestCase;
use Twitter\Http\Request;

class RequestTest extends TestCase {

    public function testRequestTrue()
    {
        $data = ['name' => 'Damien'];
        $request = new Request($data);
        $name = $request->get('name');
        $this->assertEquals('Damien',$name);
    }

    public function testRequestFalse()
    {
        $data = [];
        $request = new Request($data);
        $name = $request->get('name');
        $this->assertNull($name);
    }

    public function testRequestDefault()
    {
        $data = [];
        $request = new Request($data);
        $name = $request->get('name', 'World');
        $this->assertSame('World', $name);
    }

}