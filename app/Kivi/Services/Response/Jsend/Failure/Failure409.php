<?php  namespace Kivi\Services\Response\Jsend\Failure;

use Kivi\Services\Response\Jsend\Failure;

class Failure409 extends Failure {
    protected $statusCode = 409;

    function __construct()
    {
        $this->data = [
            'reason' => 'DuplicateEntry'
        ];
    }
} 