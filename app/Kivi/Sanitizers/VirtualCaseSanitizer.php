<?php

namespace Kivi\Sanitizers;

class VirtualCaseSanitizer
{
    public function sanitizeUrl($url)
    {
        $components = parse_url($url);
        $url = '';
        $url .= isset($components['host']) ? $components['host'] : '';
        $url .= $components['path'];
        $matches = [];
        preg_match('/(.*.svs).*/', $url, $matches);
        return 'http://' . $matches[1];
    }


}
