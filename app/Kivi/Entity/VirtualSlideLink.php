<?php namespace Kivi\Entity;


use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;

class VirtualSlideLink implements Arrayable, Jsonable
{
    /** @var string Url of the virtual slide */
    private $url;

    /** @var string Stain used in the virtual slide */
    private $stain = "H&E";

    function __construct($stain, $url)
    {
        $this->stain = $stain;
        $this->url = $url;
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