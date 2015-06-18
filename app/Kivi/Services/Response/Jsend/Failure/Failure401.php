<?php  namespace Kivi\Services\Response\Jsend\Failure;


use Kivi\Services\Response\Jsend\Failure;

class Failure401 extends Failure {
    protected $statusCode = 401;

    function __construct()
    {
        $this->content = [
            'status' => 'fail',
            'data' => [
                'reason' => 'Unauthorized'
            ]
        ];
    }
}