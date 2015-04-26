<?php

namespace Kivi\Providers;

use DOMDocument;
use DOMElement;
use DOMXPath;

use Kivi\Entity\VirtualCase;
use Kivi\Entity\VirtualSlideLink;

use anlutro\cURL\cURL;

class RosaiCollection implements ProviderInterface
{
    const LINK = "http://www.rosaicollection.net/?q=";

    /**
     * Returns array of virtual slide links
     *
     * @param $term
     * @return VirtualCase[]
     */
    public function search($term)
    {
        $curl = new cURL();
        $response = $curl->get(self::LINK . urlencode($term));
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

    /**
     * Returns virtual slide link from "casegrid" DIV
     *
     * @param DOMElement $element
     * @return VirtualSlideLink
     */
    public function parseCaseGrid(DOMElement $element)
    {
        /** @var DomElement $img */
        $img  = $element->getElementsByTagName('img')->item(0);
        $p    = $element->getElementsByTagName('p')->item(0);

        $url  = $this->parseLink($img->getAttribute('src'));
        $data = $this->parseData($p->textContent);

        $link = new VirtualSlideLink("H&E", $url);
        return new VirtualCase($data, $link);

    }

    /**
     * Extracts data from paragraph tag
     *
     * @param $string
     * @return string
     */
    public function parseData($string)
    {
        $result = preg_match("/^(.*) \[\d+\/\d+\]$/", $string, $matches);
        if ($result) {
            return $matches[1];
        }
        return "";
    }

    /**
     * Extracts url from img href attribute
     *
     * @param $url
     * @return string
     */
    public function parseLink($url)
    {
        $result = preg_match("/http:\/\/[:\._a-zA-Z0-9\/-]+\.svs/", $url, $matches);

        if ($result) {
            return $matches[0];
        }
        return "";
    }
}
