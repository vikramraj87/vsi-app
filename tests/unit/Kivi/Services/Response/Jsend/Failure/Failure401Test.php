<?php

use Kivi\Services\Response\Jsend\Failure\Failure401;

class Failure401Test extends PHPUnit_Framework_TestCase {
    /** @test */
    function it_should_generate_a_proper_401_response()
    {
        $response = new Failure401();

        $this->assertSame(401, $response->statusCode());
        $this->assertEquals(['status' => 'fail', 'data' => ['reason' => 'Unauthorized']], $response->content());
    }
} 