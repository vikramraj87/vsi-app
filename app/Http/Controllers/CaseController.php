<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Requests\CreateCaseRequest;
use Illuminate\Http\Request;

use Kivi\Repositories\CategoryRepository;
use Kivi\Repositories\VirtualSlideProviderRepository;

class CaseController extends Controller {
    /** @var VirtualSlideProviderRepository */
    private $virtualSlideProviderRepository;

    /** @var CategoryRepository */
    private $categoryRepository;

    function __construct(CategoryRepository $categoryRepository, VirtualSlideProviderRepository $virtualSlideProviderRepository)
    {
        $this->categoryRepository = $categoryRepository;
        $this->virtualSlideProviderRepository = $virtualSlideProviderRepository;
    }


    public function create()
    {
        $providers  = $this->virtualSlideProviderRepository->all();
        $categories = $this->categoryRepository->allWithRelations();

        return view('case.create', compact('providers', 'categories'));
    }

    public function store(CreateCaseRequest $request)
    {

    }

    /**
     * Populate the form if resubmitted for adding multiple slides
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
//    private function populateForm(Request $request)
//    {
//        $providers = $this->virtualSlideProviderRepository->all();
//        $categories = $this->categoryRepository->allWithRelations();
//
//        $virtual_slide_provider_id = $request->get('virtual_slide_provider_id', 0);
//        $category_id               = $request->get('category_id', 0); //Diagnosis
//        $clinical_data             = $request->get('clinical_data', '');
//
//        $slides = [];
//        if($request->exists('url')) {
//            $urls   = $request->get('url');
//            $stains = $request->get('stain');
//            for($i = 0; $i < count($urls); $i++) {
//                $slides[] = [
//                    'url'   => $urls[$i],
//                    'stain' => $stains[$i]
//                ];
//            }
//        }
//
//        // One empty slide for displaying empty form fields for getting entry
//        $slides[] = [
//            'url'   => '',
//            'stain' => ''
//        ];
//
//
//        return view('case.create', compact(
//            'providers',     'categories',   'virtual_slide_provider_id',
//            'clinical_data', 'category_id',  'slides'
//        ));
//    }
}
