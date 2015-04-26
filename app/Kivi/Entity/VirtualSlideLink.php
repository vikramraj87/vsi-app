<?php
/**
 * Created by PhpStorm.
 * User: Vikram
 * Date: 25/04/15
 * Time: 8:22 PM
 */

namespace Kivi\Entity;


use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;

class VirtualSlideLink implements Arrayable, Jsonable
{
    /** @var string Url of the virtual slide */
    private $url;

    /** @var string Stain used in the virtual slide */
    private $stain = "H&E";

    /** @var string Diagnosis or history related to the slide */
    private $data;

    function __construct($stain, $url, $data)
    {
        $this->stain = $stain;
        $this->url = $url;
        $this->data = $data;
    }

    /**
     * @return string
     */
    public function getStain()
    {
        return $this->stain;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    public function toArray()
    {
        return [
            "stain" => $this->stain,
            "url"   => $this->url,
            "data"  => $this->data
        ];
    }

    /**
     * Convert the object to its JSON representation.
     *
     * @param  int $options
     * @return string
     */
    public function toJson($options = 0)
    {
        return json_encode($this->toArray());
    }
}