<?php  namespace Kivi\Services\Response\Jsend\Failure;

use Kivi\Services\Response\Jsend\Failure;

class Failure404 extends Failure {
    protected $statusCode = 404;

    function __construct($id)
    {
        $this->content = [
            'status' => 'fail',
            'data' => [
                'reason' => 'NotFound',
                'id' => $id
            ]
        ];
    }
} 