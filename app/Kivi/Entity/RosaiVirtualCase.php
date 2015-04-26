<?php  namespace Kivi\Entity;

class RosaiVirtualCase extends VirtualCase
{
    public function __construct($data, $links)
    {
        parent::__construct($data, $links);
        $this->provider     = "Rosai Collection";
        $this->providerHome = "http://www.rosaicollection.net/";
    }
} 