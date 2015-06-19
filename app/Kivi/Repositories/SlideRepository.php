<?php  namespace Kivi\Repositories;

use App\VirtualSlide;

class SlideRepository {
    public function fetchByUrl($url)
    {
        return VirtualSlide::select(['id', 'stain', 'case_id', 'url', 'remarks'])->where('url', $url)->first();
    }
} 