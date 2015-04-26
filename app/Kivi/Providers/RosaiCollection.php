<?php

namespace Kivi\Providers;

use DOMDocument;
use DOMElement;
use DOMXPath;
use Kivi\Entity\VirtualSlideLink;
use anlutro\cURL\cURL;

class RosaiCollection
{
    private $link = "http://www.rosaicollection.net/?q=";

    public function search($term)
    {
        $curl = new cURL();
        $response = $curl->get($this->link . urlencode($term));
        $dom = new DOMDocument();
        @$dom->loadHTML($response->body);

        $xpath = new DOMXPath($dom);

        /** @var \DOMNodeList $casegrids */
        $casegrids = $xpath->query("//*[@class='casegrid']");

        $links = [];
        foreach($casegrids as $casegrid) {
            $links[] = $this->parseCaseGrid($casegrid);
        }
        return $links;
    }

    public function parseCaseGrid(DOMElement $element)
    {
        /** @var DomElement $img */
        $img  = $element->getElementsByTagName('img')->item(0);
        $p    = $element->getElementsByTagName('p')->item(0);

        $url  = $this->parseLink($img->getAttribute('src'));
        $data = $this->parseData($p->textContent);
        return new VirtualSlideLink("H&E", $url, $data);
    }

    public function parseData($string)
    {
        $result = preg_match("/^(.*) \[\d+\/\d+\]$/", $string, $matches);
        if ($result) {
            return $matches[1];
        }
        return "";
    }

    public function parseLink($url)
    {
        $result = preg_match("/http:\/\/[:\._a-zA-Z0-9\/-]+\.svs/", $url, $matches);

        if ($result) {
            return $matches[0];
        }
        return "";
    }
}
