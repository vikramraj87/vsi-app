<?php  namespace Kivi\Repositories;

use App\VirtualSlide;

class SlideRepository {
    public function urlExists($url)
    {
        return (bool) count(VirtualSlide::where('url', $url)->get());
    }
} 