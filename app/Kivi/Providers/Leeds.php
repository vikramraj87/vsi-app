<?php namespace Kivi\Providers;

use anlutro\cURL\cURL;

use DOMDocument;
use DOMElement;
use DOMXPath;

use Kivi\Entity\LeedsVirtualCase;
use Kivi\Entity\VirtualCase;
use Kivi\Entity\VirtualSlideLink;

class Leeds implements ProviderInterface
{
    const URL = "http://www.virtualpathology.leeds.ac.uk/slidelibrary/index.php";

    /**
     * Returns array of virtual cases
     *
     * @param $term
     * @return array|\Kivi\Entity\VirtualCase[]
     */
    public function search($term)
    {
        $params = [
            "what"      => "Diagnosis",
            "diagnosis" => $term
        ];

        $curl = new cURL();
        $response = $curl->post(self::URL, $params);

        $dom = new DOMDocument();
        @$dom->loadHTML($response->body);

        $xpath = new DOMXPath($dom);

        /** @var \DOMNodeList $containers */
        $containers = $xpath->query("//*[@class='container']");

        $cases = [];
        foreach($containers as $container) {
            /** @var DOMElement $container */

            $divs = $container->getElementsByTagName('div');
            $case = new LeedsVirtualCase(
                $this->parseHistory($divs->item(0)),
                $this->parseLinks($divs->item(1))
            );
            $cases[] = $case;
        }
        return $cases;
    }

    /**
     * Parses DOMElement to string by removing extra spaces and
     * unwanted br, span tags, etc.
     *
     * @param DOMElement $element
     * @return string
     */
    public function parseHistory(DOMElement $element)
    {
        $parts = [];

        // Extracting only the text and removing extra spaces
        foreach($element->childNodes as $childNode) {
            /** @var DOMElement $childNode */

            if($childNode->nodeName == '#text') {
                $parts[] = trim(preg_replace("/\s+/", " ", $childNode->textContent), ".");
            }
        }

        // Removing the last item beacause it contains only weird symbols
        array_pop($parts);

        // Finally combining the parts to give a sentence
        return(implode(". ", $parts));
    }

    /**
     * Returns the virtual slide links for the case
     *
     * @param DOMElement $element
     * @return VirtualSlideLink[]
     */
    public function parseLinks(DOMElement $element)
    {
        $links = [];

        // Get all the image tags
        $images = $element->getElementsByTagName("img");

        for($i=0; $i < $images->length; $i++) {
            /** @var DOMElement $img */
            $img = $images->item($i);

            // Determine the stain used
            $stain = "";
            $tmp = $img->parentNode->previousSibling;
            while($tmp && $tmp->nodeName != "a") {
                if($tmp->nodeName == "#text") {
                    $stain = $tmp->textContent;
                    break;
                }
                $tmp = $tmp->previousSibling;
            }

            // Extract the url from the src attribute
            $rawLinkSrc = $img->getAttribute('src');
            $result = preg_match("/(http:\/\/[:\._a-zA-Z0-9\/-]+\.svs)\?0\+0\+(\d+)\+(\d+)/", $rawLinkSrc, $matches);

            if ($result) {
                $links[] = new VirtualSlideLink($stain, $matches[1]);
            }
        }
        return $links;
    }
}
