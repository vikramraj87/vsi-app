<?php

namespace spec\Kivi\Sanitizers;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class VirtualCaseSanitizerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Kivi\Sanitizers\VirtualCaseSanitizer');
    }

    function it_parses_leeds_svs_url()
    {
        $this->sanitizeUrl('129.11.191.7/Research_4/Teaching/Education/Teaching/MFD_GI/Oesophagus/4439.svs/view.apml?returnurl=http://www.virtualpathology.leeds.ac.uk/slidelibrary/index.php')
             ->shouldReturn('http://129.11.191.7/Research_4/Teaching/Education/Teaching/MFD_GI/Oesophagus/4439.svs');
        $this->sanitizeUrl('http://129.11.191.7/Research_4/Teaching/Education/Teaching/MFD_GI/Oesophagus/4439.svs/view.apml?returnurl=http://www.virtualpathology.leeds.ac.uk/slidelibrary/index.php')
            ->shouldReturn('http://129.11.191.7/Research_4/Teaching/Education/Teaching/MFD_GI/Oesophagus/4439.svs');
    }

    function it_parses_rosai_svs_url()
    {
        $this->sanitizeUrl('http://rosai.secondslide.com/sem1/sem1-case5.svs/')
             ->shouldReturn('http://rosai.secondslide.com/sem1/sem1-case5.svs');
    }
}
