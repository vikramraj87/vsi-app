<?php
/**
 * Created by PhpStorm.
 * User: Vikram
 * Date: 18/04/15
 * Time: 11:14 AM
 */

namespace Kivi\Providers;

use anlutro\cURL\cURL;
use DOMDocument;
use DOMElement;

class Leeds {
    private $url = "http://www.virtualpathology.leeds.ac.uk/slidelibrary/index.php";

    public $containers;

    public function search($term)
    {
        $params = [
            "what"      => "Diagnosis",
            "diagnosis" => $term
        ];

        $curl = new cURL();

        $response = $curl->post($this->url, $params);


        $dom = new \DOMDocument();
        @$dom->loadHTML($response->body);

        $xpath = new \DOMXPath($dom);

        /** @var \DOMNodeList $containers */
        $containers = $xpath->query("//*[@class='container']");

        $output = [];
        foreach($containers as $container) {
            /** @var DOMElement $container */

            $divs = $container->getElementsByTagName('div');
            $case = [
                "history" => $this->parseHistory($divs->item(0)),
                "slides"  => $this->parseLinks($divs->item(1))
            ];
            $output[] = $case;
        }
        return $output;
    }

    /**
     * Parses DOMElement to string by removing extra spaces and
     * unwanted <br/>, <span> tags, etc.
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
        $history = implode(". ", $parts);
        return($history);
    }

    public function parseLinks(DOMElement $element)
    {
        $links = [];
        $images = $element->getElementsByTagName("img");
        for($i=0; $i < $images->length; $i++) {
            /** @var DOMElement $img */
            $img = $images->item($i);
            $stain = "";
            $tmp = $img->parentNode->previousSibling;
            while($tmp && $tmp->nodeName != "a") {
                if($tmp->nodeName == "#text") {
                    $stain = $tmp->textContent;
                    break;
                }
                $tmp = $tmp->previousSibling;
            }
            $rawLinkSrc = $img->getAttribute('src');

            $result = preg_match("/(http:\/\/[:\._a-zA-Z0-9\/-]+\.svs)\?0\+0\+(\d+)\+(\d+)/", $rawLinkSrc, $matches);

            if ($result) {
                $links[] = [
                    "stain" => $stain,
                    "link" => $matches[1],
                    "x" => $matches[2],
                    "y" => $matches[3]
                ];
            }
        }
        return $links;
    }
}
