<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Kivi\Repositories\SlideRepository;

class SlideController extends Controller {
    /** @var SlideRepository */
    protected $slideRepository;

    function __construct(SlideRepository $slideRepository)
    {
        $this->slideRepository = $slideRepository;
    }

    public function checkUrl(Request $request)
    {
        $url = $request->get('url');

        if("" === $url) {
            return response()->jsend('success');
        }

        $slide = $this->slideRepository->fetchByUrl($url);

        if(null === $slide) {
            return response()->jsend('success');
        }
        return response()->jsend('fail', [
            'reason' => 'SlideWithUrlExists',
            'slide' => $slide
        ]);
    }
}
