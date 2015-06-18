<?php namespace Kivi\Services\Response\Jsend;

use Kivi\Services\Response\Jsend;

abstract class Success extends Jsend {
    function __construct(array $data = [])
    {
        $this->content = [
            'status' => 'success',
            'data' => $data
        ];
    }
} 