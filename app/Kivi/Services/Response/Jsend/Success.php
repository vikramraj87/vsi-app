<?php namespace Kivi\Services\Response\Jsend;

use Kivi\Services\Response\Jsend;

abstract class Success extends Jsend {
    protected $status = 'success';

    function __construct(array $data = [])
    {
        $this->data = $data;
    }
} 