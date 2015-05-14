<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Requests\CreateCaseRequest;
use App\VirtualSlide;
use Illuminate\Http\Request;

use App\VirtualCase;
use Kivi\Repositories\CategoryRepository;
use Kivi\Repositories\VirtualSlideProviderRepository;
use Kivi\Repositories\CaseRepository;

class CaseController extends Controller {
    /** @var VirtualSlideProviderRepository */
    private $virtualSlideProviderRepository;

    /** @var CategoryRepository */
    private $categoryRepository;

    /** @var CaseRepository */
    private $caseRepository;

    function __construct(
        CategoryRepository $categoryRepository,
        VirtualSlideProviderRepository $virtualSlideProviderRepository,
        CaseRepository $caseRepository
    )
    {
        $this->categoryRepository             = $categoryRepository;
        $this->virtualSlideProviderRepository = $virtualSlideProviderRepository;
        $this->caseRepository                 = $caseRepository;
    }

    public function index($parentId = 0)
    {
        $category = null;
        $parents = null;
        $parentId = intval($parentId);

        if($parentId > 0) {
            $category = $this->categoryRepository->find($parentId);
            $subCategories = $category->subCategories;
            $parents = $this->categoryRepository->parents($category->id);
        } else {
            $subCategories = $this->categoryRepository->topLevelCategories();
        }
        $providers = $this->virtualSlideProviderRepository->all();

        $hierarchicalCategories = $this->categoryRepository->hierarchicalCategoryIds($parentId);
        $cases = $this->caseRepository->casesByCategories($hierarchicalCategories);
        return view('case.index', compact('category', 'subCategories', 'parents', 'providers', 'cases'));
    }

    public function show()
    {

    }


    public function store(CreateCaseRequest $request)
    {
        $caseData = [
            'virtual_slide_provider_id' => $request->get('virtual_slide_provider_id'),
            'clinical_data'             => $request->get('clinical_data'),
            'category_id'               => $request->get('category_id')
        ];

        $slideData = [];
        for($i = 0; $i < count($request->get('url')); $i++) {
            $slideData[] = [
                'url'   => $request->get('url')[$i],
                'stain' => $request->get('stain')[$i]
            ];
        }

        $result = $this->caseRepository->create($caseData, $slideData);
        // todo: check result for true
        $redirectUrl = $request->get('category_id') == null ? 'cases' : 'cases/' . $request->get('category_id');
        return redirect($redirectUrl);
    }
}
