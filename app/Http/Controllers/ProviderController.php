<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Kivi\Repositories\VirtualSlideProviderRepository;

use Illuminate\Http\Request;

class ProviderController extends Controller {
    /** @var VirtualSlideProviderRepository */
    private $providerRepository;

    function __construct(VirtualSlideProviderRepository $providerRepository)
    {
        $this->providerRepository = $providerRepository;
    }


    public function index()
    {
        return $this->providerRepository->all();
    }
}
