<?php  namespace Kivi\Services\Response;

abstract class Jsend {
    /** @var int HTTP status code */
    protected $statusCode = 0;

    /** @var string Indicating success or failure of JSON response */
    protected $status = '';

    /** @var array Holding the response data */
    protected $data;

    /**
     * Returns the HTTP status code
     *
     * @return int
     */
    public function statusCode()
    {
        return $this->statusCode;
    }

    /**
     * Returns the response array for JSON response
     *
     * @return array
     */
    public function content()
    {
        return [
            'status' => $this->status,
            'data' => $this->data
        ];
    }


} 