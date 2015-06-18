<?php  namespace Kivi\Services\Response\Jsend\Failure;

use Kivi\Services\Response\Jsend\Failure;

class Failure400 extends Failure {
    protected $statusCode = 400;

    public function __construct(array $validationErrors = [])
    {
        $this->content = [
            'status' => 'fail',
            'data' => [
                'reason' => 'ValidationFailed',
                'errors' => $validationErrors
            ]
        ];
    }
} 