<?php

namespace spec\Kivi\Providers;

use DOMDocument;
use DOMElement;
use Kivi\Entity\RosaiVirtualCase;
use Kivi\Entity\VirtualCase;
use Kivi\Entity\VirtualSlideLink;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class RosaiCollectionSpec extends ObjectBehavior
{
    public function it_parses_a_link_1()
    {
        $this->parseLink("http://rosai.secondslide.com/sem40/sem40-case23.svs?0+0+175+0")
             ->shouldReturn("http://rosai.secondslide.com/sem40/sem40-case23.svs");
    }

    public function it_parses_a_link_2()
    {
        $this->parseLink("http://rosai.secondslide.com/sem335/sem335-case8.svs?0+0+175+0")
            ->shouldReturn("http://rosai.secondslide.com/sem335/sem335-case8.svs");
    }

    public function it_parses_data_1()
    {
        $this->parseData("Histiocytoid hemangioma (Heart) [358/7]")
             ->shouldReturn("Histiocytoid hemangioma (Heart)");
    }

    public function it_parses_data_2()
    {
        $this->parseData("Hemangioma (Skin) [549/5]")
             ->shouldReturn("Hemangioma (Skin)");
    }

    public function it_parses_a_case_grid_1()
    {
        $html = <<<EOD
            <div class="casegrid">
            <a href="http://rosai.secondslide.com/sem557/sem557-case5.svs" target="_blank"><img src="http://rosai.secondslide.com/sem557/sem557-case5.svs?0+0+175+0" alt="Hemangioma (Inguinal region (canine)) [557/5]" /></a>
            <p>Hemangioma (Inguinal region (canine)) [557/5]</p>
            </div>
EOD;
        $div = $this->generateDomFromRawHtml($html);

        $links = [new VirtualSlideLink("H&E", "http://rosai.secondslide.com/sem557/sem557-case5.svs")];
        $case = new RosaiVirtualCase("Hemangioma (Inguinal region (canine))", $links);

        $this->parseCaseGrid($div)
             ->shouldBeLike($case);
    }

    public function it_parses_a_case_grid_2()
    {
        $html = <<<EOD
            <div class="casegrid">
            <a href="http://rosai.secondslide.com/sem580/sem580-case11.svs" target="_blank"><img src="http://rosai.secondslide.com/sem580/sem580-case11.svs?0+0+175+0" alt="Sclerosing hemangioma (lung) [580/11]" /></a>
            <p>Sclerosing hemangioma (lung) [580/11]</p>
            </div>
EOD;
        $div = $this->generateDomFromRawHtml($html);

        $links = [new VirtualSlideLink("H&E", "http://rosai.secondslide.com/sem580/sem580-case11.svs")];
        $case = new RosaiVirtualCase("Sclerosing hemangioma (lung)", $links);

        $this->parseCaseGrid($div)
            ->shouldBeLike($case);
    }

    /**
     * @param $html
     * @return DOMElement
     */
    private function generateDomFromRawHtml($html)
    {
        $domHtml = new DOMDocument();
        $domHtml->loadHTML($html);
        return $domHtml->getElementsByTagName("div")->item(0);
    }


}
