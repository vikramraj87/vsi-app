<?php

use Kivi\Services\Response\Jsend\Failure\Failure409;

class Failure409Test extends PHPUnit_Framework_TestCase {

    /** @test */
    function it_should_generate_a_proper_409_response()
    {
        $response = new Failure409();

        $this->assertSame(409, $response->statusCode());
        $this->assertEquals(['status' => 'fail', 'data' => ['reason' => 'DuplicateEntry']], $response->content());
    }
} 