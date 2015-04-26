<?php namespace Kivi\Entity;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;

class VirtualCase implements Arrayable, Jsonable
{
    /** @var string */
    private $data;

    /** @var VirtualSlideLink[] */
    private $links;

    /** @var string Provider of the case */
    protected $provider;

    /** @var string Url of the provider home page */
    protected $providerHome;

    function __construct($data, $links)
    {
        if($links instanceof VirtualSlideLink) {
            $links = [$links];
        }

        $this->data         = $data;
        $this->links        = $links;
    }

    /**
     * @return string
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return VirtualSlideLink[]
     */
    public function getLinks()
    {
        return $this->links;
    }

    /**
     * @return string
     */
    public function getProvider()
    {
        return $this->provider;
    }

    /**
     * @return string
     */
    public function getProviderHome()
    {
        return $this->providerHome;
    }



    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        // TODO: Implement toArray() method.
    }

    /**
     * Convert the object to its JSON representation.
     *
     * @param  int $options
     * @return string
     */
    public function toJson($options = 0)
    {
        // TODO: Implement toJson() method.
    }
}