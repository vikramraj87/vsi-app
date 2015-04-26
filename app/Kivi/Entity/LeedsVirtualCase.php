<?php  namespace Kivi\Entity;

class LeedsVirtualCase extends VirtualCase
{
    public function __construct($data, $links)
    {
        parent::__construct($data, $links);
        $this->provider     = "University of Leeds";
        $this->providerHome = "http://www.virtualpathology.leeds.ac.uk/slidelibrary/index.php";
    }
} 