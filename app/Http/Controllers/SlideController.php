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
        $this->middleware('admin', ['only' => 'checkUrl']);
    }

    public function checkUrl(Request $request, $exceptId = 0)
    {
        $url = $request->get('url');
        $exceptId = intval($exceptId);

        if("" === $url) {
            return response()->jsend('success');
        }

        $slide = $this->slideRepository->fetchByUrl($url);

        if(null === $slide) {
            return response()->jsend('success');
        }
        if($exceptId !== 0 && $slide->id === $exceptId) {
            return response()->jsend('success');
        }
        return response()->jsend('fail', [
            'reason' => 'SlideWithUrlExists',
            'slide' => $slide
        ]);
    }
}
