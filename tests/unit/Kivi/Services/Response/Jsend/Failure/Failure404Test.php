<?php 

use Kivi\Services\Response\Jsend\Failure\Failure404;

class Failure404Test extends PHPUnit_Framework_TestCase {
    /** @test */
    function it_should_generate_a_proper_409_response()
    {
        $response = new Failure404(1001);

        $this->assertSame(404, $response->statusCode());
        $this->assertEquals(['status' => 'fail', 'data' => ['reason' => 'NotFound', 'id' => 1001]], $response->content());
    }
} 