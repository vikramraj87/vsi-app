<?php

namespace spec\Kivi\Providers;

use DOMDocument;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class LeedsSpec extends ObjectBehavior
{
    function it_converts_raw_html_to_string_of_history_1()
    {
        $raw = <<<EOD
<div class="container"><br>Male  53 years<br><br>Chest wall lump measuring 3.5 x 1.0 x 1.0cm.
S100 positive, HHF35 and smooth muscle antibody (SMA) negative.<br><br><br><br><button onclick="loadXMLDoc5(' slide_library_xml/Research_4TeachingEQANWCirc_U1776/results.xml')">View full details</button>&nbsp;&nbsp;<br><br><span id="A3_5"></span></div>
EOD;

        $expected = "Male 53 years. Chest wall lump measuring 3.5 x 1.0 x 1.0cm. S100 positive, HHF35 and smooth muscle antibody (SMA) negative";

        $this->parseHistory($this->getDomElementFromRawHtml($raw))->shouldReturn($expected);
    }

    function it_converts_raw_html_to_string_of_history_2()
    {
        $raw = <<<EOD
<div class="box_content"><br>Male  55 years<br><br>Retroperitoneal tumour.<br><br><br><br><button onclick="loadXMLDoc3(' slide_library_xml/Research_4Slide_LibraryR_Bishop_CollectionCard_index_SetSoft_tissue689/results.xml')">View full details</button>&nbsp;&nbsp;<br><br><span id="A3_3"></span></div>
EOD;

        $expected = "Male 55 years. Retroperitoneal tumour";
        $this->parseHistory($this->getDomElementFromRawHtml($raw))->shouldReturn($expected);
    }

    function it_converts_raw_html_to_string_of_history_3()
    {
        $raw = <<<EOD
<div class="box_content"><br>Female  13 years<br><br>Cystic lesion from dorsum of left index finger. Clinically ganglion from dorsal surface of the left index finger over proximal interphalangeal joint.  No apparent communication with joint on internal inspection.<br><br><br><br><button onclick="loadXMLDoc4(' slide_library_xml/Research_4Slide_LibraryDarren_CollectionSet_21414/results.xml')">View full details</button>&nbsp;&nbsp;<br><br><span id="A3_4"></span></div>
EOD;

        $expected = "Female 13 years. Cystic lesion from dorsum of left index finger. Clinically ganglion from dorsal surface of the left index finger over proximal interphalangeal joint. No apparent communication with joint on internal inspection";
        $this->parseHistory($this->getDomElementFromRawHtml($raw))->shouldReturn($expected);
    }

//    function it_converts_raw_html_to_links_1()
//    {
//        $raw = <<<EOD
//<div class="illustration"><br>H&amp;E<br><script language="javascript">function open162670 () { my162670=window.open('http://129.11.191.7:80/Research_4/Slide_Library/Sara_Edward/Set_19/162670.svs/view.apml?returnurl=http://www.virtualpathology.leeds.ac.uk/slidelibrary/index.php','162670',"menubar=0,location=0,status=0,resizable=1"); my162670.focus();}</script><a href="javascript: open162670()"><img src="http://129.11.191.7:80/Research_4/Slide_Library/Sara_Edward/Set_19/162670.svs?0+0+150+99+-1+75" alt="Image Server temporarily unavailable" title="" border="0"></a><br><script language="javascript">function open162670 () { my162670=window.open('http://129.11.191.7:80/Research_4/Slide_Library/Sara_Edward/Set_19/162670.svs/view.apml?returnurl=http://www.virtualpathology.leeds.ac.uk/slidelibrary/index.php','162670',"menubar=0,location=0,status=0,resizable=1"); my162670.focus();}</script><a href="javascript: open162670()">Open with WebScope</a><br><br></div>
//EOD;
//        $expected = [
//            [
//                "stain" => "H&E",
//                "link"  => "http://129.11.191.7:80/Research_4/Slide_Library/Sara_Edward/Set_19/162670.svs",
//                "x"     => "150",
//                "y"     => "99"
//            ]
//        ];
//        $this->parseLinks($this->getDomElementFromRawHtml($raw))->shouldReturn($expected);
//    }
//
//    function it_converts_raw_html_to_links_2()
//    {
//        $raw = <<<EOD
//    <div class="illustration"><br>H&amp;E<br><script language="javascript">function open61219 () { my61219=window.open('http://129.11.191.7:80/Research_4/Teaching/Education/Postgraduate/Black_Box/17-Jul-08/61219.svs/view.apml?returnurl=http://www.virtualpathology.leeds.ac.uk/slidelibrary/index.php','61219',"menubar=0,location=0,status=0,resizable=1"); my61219.focus();}</script><a href="javascript: open61219()"><img src="http://129.11.191.7:80/Research_4/Teaching/Education/Postgraduate/Black_Box/17-Jul-08/61219.svs?0+0+150+52+-1+75" alt="Image Server temporarily unavailable" title="" border="0"></a><br><script language="javascript">function open61219 () { my61219=window.open('http://129.11.191.7:80/Research_4/Teaching/Education/Postgraduate/Black_Box/17-Jul-08/61219.svs/view.apml?returnurl=http://www.virtualpathology.leeds.ac.uk/slidelibrary/index.php','61219',"menubar=0,location=0,status=0,resizable=1"); my61219.focus();}</script><a href="javascript: open61219()">Open with WebScope</a><br><br></div>
//EOD;
//        $expected = [
//            [
//                "stain" => "H&E",
//                "link"  => "http://129.11.191.7:80/Research_4/Teaching/Education/Postgraduate/Black_Box/17-Jul-08/61219.svs",
//                "x"     => "150",
//                "y"     => "52"
//            ]
//        ];
//        $this->parseLinks($this->getDomElementFromRawHtml($raw))->shouldReturn($expected);
//    }
//
//    function it_parses_case_with_multiple_slides_also()
//    {
//        $raw = <<<EOD
//<div class="illustration"><br>H&amp;E<br><script language="javascript">function open11185 () { my11185=window.open('http://129.11.191.7:80/Research_4/Teaching/Education/Teaching/MFD_GI/Duodenum/11185.svs/view.apml?returnurl=http://www.virtualpathology.leeds.ac.uk/slidelibrary/index.php','11185',"menubar=0,location=0,status=0,resizable=1"); my11185.focus();}</script><a href="javascript: open11185()"><img src="http://129.11.191.7:80/Research_4/Teaching/Education/Teaching/MFD_GI/Duodenum/11185.svs?0+0+150+92+-1+75" alt="Image Server temporarily unavailable" title="" border="0"></a><br><script language="javascript">function open11185 () { my11185=window.open('http://129.11.191.7:80/Research_4/Teaching/Education/Teaching/MFD_GI/Duodenum/11185.svs/view.apml?returnurl=http://www.virtualpathology.leeds.ac.uk/slidelibrary/index.php','11185',"menubar=0,location=0,status=0,resizable=1"); my11185.focus();}</script><a href="javascript: open11185()">Open with WebScope</a><br><br><br>H&amp;E<br><script language="javascript">function open11189 () { my11189=window.open('http://129.11.191.7:80/Research_4/Teaching/Education/Teaching/MFD_GI/Duodenum/11189.svs/view.apml?returnurl=http://www.virtualpathology.leeds.ac.uk/slidelibrary/index.php','11189',"menubar=0,location=0,status=0,resizable=1"); my11189.focus();}</script><a href="javascript: open11189()"><img src="http://129.11.191.7:80/Research_4/Teaching/Education/Teaching/MFD_GI/Duodenum/11189.svs?0+0+150+59+-1+75" alt="Image Server temporarily unavailable" title="" border="0"></a><br><script language="javascript">function open11189 () { my11189=window.open('http://129.11.191.7:80/Research_4/Teaching/Education/Teaching/MFD_GI/Duodenum/11189.svs/view.apml?returnurl=http://www.virtualpathology.leeds.ac.uk/slidelibrary/index.php','11189',"menubar=0,location=0,status=0,resizable=1"); my11189.focus();}</script><a href="javascript: open11189()">Open with WebScope</a><br><br></div>
//EOD;
//        $expected = [
//            [
//                "stain" => "H&E",
//                "link"  => "http://129.11.191.7:80/Research_4/Teaching/Education/Teaching/MFD_GI/Duodenum/11185.svs",
//                "x"     => "150",
//                "y"     => "92"
//            ],
//            [
//                "stain" => "H&E",
//                "link"  => "http://129.11.191.7:80/Research_4/Teaching/Education/Teaching/MFD_GI/Duodenum/11189.svs",
//                "x"     => "150",
//                "y"     => "59"
//            ]
//        ];
//        $this->parseLinks($this->getDomElementFromRawHtml($raw))->shouldReturn($expected);
//    }
//
//    function it_parses_case_with_multiple_slides_also_1()
//    {
//        $raw = <<<EOD
//<div class="illustration"><br>H&amp;E<br><script language="javascript">function open11185 () { my11185=window.open('http://129.11.191.7:80/Research_4/Teaching/Education/Teaching/MFD_GI/Duodenum/11185.svs/view.apml?returnurl=http://www.virtualpathology.leeds.ac.uk/slidelibrary/index.php','11185',"menubar=0,location=0,status=0,resizable=1"); my11185.focus();}</script><a href="javascript: open11185()"><img src="http://129.11.191.7:80/Research_4/Teaching/Education/Teaching/MFD_GI/Duodenum/11185.svs?0+0+150+92+-1+75" alt="Image Server temporarily unavailable" title="" border="0"></a><br><script language="javascript">function open11185 () { my11185=window.open('http://129.11.191.7:80/Research_4/Teaching/Education/Teaching/MFD_GI/Duodenum/11185.svs/view.apml?returnurl=http://www.virtualpathology.leeds.ac.uk/slidelibrary/index.php','11185',"menubar=0,location=0,status=0,resizable=1"); my11185.focus();}</script><a href="javascript: open11185()">Open with WebScope</a><br><br><br>H&amp;E<br><script language="javascript">function open11189 () { my11189=window.open('http://129.11.191.7:80/Research_4/Teaching/Education/Teaching/MFD_GI/Duodenum/11189.svs/view.apml?returnurl=http://www.virtualpathology.leeds.ac.uk/slidelibrary/index.php','11189',"menubar=0,location=0,status=0,resizable=1"); my11189.focus();}</script><a href="javascript: open11189()"><img src="http://129.11.191.7:80/Research_4/Teaching/Education/Teaching/MFD_GI/Duodenum/11189.svs?0+0+150+59+-1+75" alt="Image Server temporarily unavailable" title="" border="0"></a><br><script language="javascript">function open11189 () { my11189=window.open('http://129.11.191.7:80/Research_4/Teaching/Education/Teaching/MFD_GI/Duodenum/11189.svs/view.apml?returnurl=http://www.virtualpathology.leeds.ac.uk/slidelibrary/index.php','11189',"menubar=0,location=0,status=0,resizable=1"); my11189.focus();}</script><a href="javascript: open11189()">Open with WebScope</a><br><br></div>
//EOD;
//        $expected = [
//            [
//                "stain" => "H&E",
//                "link"  => "http://129.11.191.7:80/Research_4/Teaching/Education/Teaching/MFD_GI/Duodenum/11185.svs",
//                "x"     => "150",
//                "y"     => "92"
//            ],
//            [
//                "stain" => "H&E",
//                "link"  => "http://129.11.191.7:80/Research_4/Teaching/Education/Teaching/MFD_GI/Duodenum/11189.svs",
//                "x"     => "150",
//                "y"     => "59"
//            ]
//        ];
//        $this->parseLinks($this->getDomElementFromRawHtml($raw))->shouldReturn($expected);
//    }
//
//    function it_parses_case_with_multiple_slides_also_2()
//    {
//        $raw = <<<EOD
//<div class="illustration"><br>H&amp;E<br><script language="javascript">function open29269 () { my29269=window.open('http://129.11.191.7:80/Research_4/Slide_Library/MFD_Collection/Full_Collection/29269.svs/view.apml?returnurl=http://www.virtualpathology.leeds.ac.uk/slidelibrary/index.php','29269',"menubar=0,location=0,status=0,resizable=1"); my29269.focus();}</script><a href="javascript: open29269()"><img src="http://129.11.191.7:80/Research_4/Slide_Library/MFD_Collection/Full_Collection/29269.svs?0+0+149+150+-1+75" alt="Image Server temporarily unavailable" title="" border="0"></a><br><script language="javascript">function open29269 () { my29269=window.open('http://129.11.191.7:80/Research_4/Slide_Library/MFD_Collection/Full_Collection/29269.svs/view.apml?returnurl=http://www.virtualpathology.leeds.ac.uk/slidelibrary/index.php','29269',"menubar=0,location=0,status=0,resizable=1"); my29269.focus();}</script><a href="javascript: open29269()">Open with WebScope</a><br><br><br><br><script language="javascript">function open29271 () { my29271=window.open('http://129.11.191.7:80/Research_4/Slide_Library/MFD_Collection/Full_Collection/29271.svs/view.apml?returnurl=http://www.virtualpathology.leeds.ac.uk/slidelibrary/index.php','29271',"menubar=0,location=0,status=0,resizable=1"); my29271.focus();}</script><a href="javascript: open29271()"><img src="http://129.11.191.7:80/Research_4/Slide_Library/MFD_Collection/Full_Collection/29271.svs?0+0+150+125+-1+75" alt="Image Server temporarily unavailable" title="" border="0"></a><br><script language="javascript">function open29271 () { my29271=window.open('http://129.11.191.7:80/Research_4/Slide_Library/MFD_Collection/Full_Collection/29271.svs/view.apml?returnurl=http://www.virtualpathology.leeds.ac.uk/slidelibrary/index.php','29271',"menubar=0,location=0,status=0,resizable=1"); my29271.focus();}</script><a href="javascript: open29271()">Open with WebScope</a><br><br><br>Keratin CAM5.2<br><script language="javascript">function open29273 () { my29273=window.open('http://129.11.191.7:80/Research_4/Slide_Library/MFD_Collection/Full_Collection/29273.svs/view.apml?returnurl=http://www.virtualpathology.leeds.ac.uk/slidelibrary/index.php','29273',"menubar=0,location=0,status=0,resizable=1"); my29273.focus();}</script><a href="javascript: open29273()"><img src="http://129.11.191.7:80/Research_4/Slide_Library/MFD_Collection/Full_Collection/29273.svs?0+0+150+80+-1+75" alt="Image Server temporarily unavailable" title="" border="0"></a><br><script language="javascript">function open29273 () { my29273=window.open('http://129.11.191.7:80/Research_4/Slide_Library/MFD_Collection/Full_Collection/29273.svs/view.apml?returnurl=http://www.virtualpathology.leeds.ac.uk/slidelibrary/index.php','29273',"menubar=0,location=0,status=0,resizable=1"); my29273.focus();}</script><a href="javascript: open29273()">Open with WebScope</a><br><br></div>
//EOD;
//        $expected = [
//            [
//                "stain" => "H&E",
//                "link"  => "http://129.11.191.7:80/Research_4/Slide_Library/MFD_Collection/Full_Collection/29269.svs",
//                "x"     => "149",
//                "y"     => "150"
//            ],
//            [
//                "stain" => "",
//                "link"  => "http://129.11.191.7:80/Research_4/Slide_Library/MFD_Collection/Full_Collection/29271.svs",
//                "x"     => "150",
//                "y"     => "125"
//            ],
//            [
//                "stain" => "Keratin CAM5.2",
//                "link"  => "http://129.11.191.7:80/Research_4/Slide_Library/MFD_Collection/Full_Collection/29273.svs",
//                "x"     => "150",
//                "y"     => "80"
//            ]
//        ];
//        $this->parseLinks($this->getDomElementFromRawHtml($raw))->shouldReturn($expected);
//    }

    private function getDomElementFromRawHtml($rawHtml)
    {
        $dom = new \DOMDocument();
        $dom->loadHTML($rawHtml);
        return $dom->getElementsByTagName("div")->item(0);
    }
}
