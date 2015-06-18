<?php
use Kivi\Services\Response\Jsend\Success\Success200;
class Success200Test extends PHPUnit_Framework_TestCase {

    /** @test */
    function it_should_generate_a_proper_200_response()
    {
        $data = [
            'id' => 1,
            'name' => 'dummy'
        ];
        $response = new Success200($data);

        $this->assertSame(200, $response->statusCode());
        $this->assertEquals(['status' => 'success', 'data' => $data], $response->content());
    }
} 