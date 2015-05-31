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

        if($this->slideRepository->urlExists($url)) {
            return response()->jsend('fail', ['reason' => 'UrlAlreadyExists']);
        }
        return response()->jsend('success');
    }
}
