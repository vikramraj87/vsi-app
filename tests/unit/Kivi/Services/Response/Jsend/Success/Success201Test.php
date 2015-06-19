<?php

use Kivi\Services\Response\Jsend\Success\Success201;

class Success201Test extends PHPUnit_Framework_TestCase {
    /** @test */
    function it_should_generate_a_proper_201_response()
    {
        $data = [
            'id' => 1,
            'name' => 'dummy'
        ];
        $response = new Success201($data);

        $this->assertSame(201, $response->statusCode());
        $this->assertEquals(['status' => 'success', 'data' => $data], $response->content());
    }
}
 