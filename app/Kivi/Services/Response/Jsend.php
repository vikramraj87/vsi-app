<?php  namespace Kivi\Services\Response;

abstract class Jsend {
    protected $statusCode = 0;

    protected $content = [];

    /**
     * @return integer
     */
    public function statusCode()
    {
        return $this->statusCode;
    }

    /**
     * @return array
     */
    public function content()
    {
        return $this->content;
    }


} 