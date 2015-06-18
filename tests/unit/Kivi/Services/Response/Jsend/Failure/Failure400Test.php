<?php

use Kivi\Services\Response\Jsend\Failure\Failure400;

class Failure400Test extends PHPUnit_Framework_TestCase {

    /** @test */
    function it_should_generate_a_proper_400_response()
    {
        $errors = [
            'Email is required',
            'Password is required'
        ];

        $response = new Failure400($errors);

        $this->assertSame(400, $response->statusCode());
        $this->assertEquals(['status' => 'fail', 'data' => ['reason' => 'ValidationFailed', 'errors' => $errors]], $response->content());
    }
} 