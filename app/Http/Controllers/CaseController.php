<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Requests\CreateCaseRequest;
use App\Http\Requests\UpdateCaseRequest;
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
        $parents  = [];
        $parentId = intval($parentId);

        if($parentId > 0) {
            $category      = $this->categoryRepository->find($parentId);
            $subCategories = $category->subCategories;
            $parents       = $this->categoryRepository->parents($category->id);
        } else {
            $subCategories = $this->categoryRepository->topLevelCategories();
        }

        $providers              = $this->virtualSlideProviderRepository->all();
        $hierarchicalCategories = $this->categoryRepository->hierarchicalCategoryIds($parentId);
        $cases                  = $this->caseRepository->casesByCategories($hierarchicalCategories);

        return view('case.index', compact('category', 'subCategories', 'parents', 'providers', 'cases'));
    }

    /**
     * Shows a single record for editing or deleting
     *
     * @param $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $case             = $this->caseRepository->find($id);
        $providers        = $this->virtualSlideProviderRepository->all();
        $parentCategories = $this->categoryRepository->parents($case->category->id);

        $parentIds = [];
        foreach($parentCategories as $cat) {
            $parentIds[] = $cat->category;
        }
        $parentIds[] = $case->category->category;

        return view('case.show', compact('case', 'providers', 'parentIds'));
    }

    /**
     * Creates a new case record
     *
     * @param CreateCaseRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreateCaseRequest $request)
    {
        $caseData  = $this->getCaseDataFromRequest($request);
        $slideData = $this->getSlideDataFromRequest($request);

        $result = $this->caseRepository->create($caseData, $slideData);

        // todo: Handle $result is false

        return redirect()->route('case-category', $request->get('category_id'));
    }

    /**
     * Updates a case record identified by the id hidden field
     *
     * @param UpdateCaseRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateCaseRequest $request)
    {
        $caseData  = $this->getCaseDataFromRequest($request);
        $slideData = $this->getSlideDataFromRequest($request);
        $id = $request->get('id');

        $result = $this->caseRepository->update($id, $caseData, $slideData);

        // todo: handle $result is false

        return redirect()->route('case-category', $caseData['category_id']);
    }

    /**
     * Deletes a case record identified by the id
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request, $id)
    {
        /** @var VirtualCase $case */
        $case = $this->caseRepository->find($id);

        // Delete the slides of the case
        $case->slides()->delete();

        // Delete the case itself
        $case->delete();

        return redirect()->route('case-category', $request->get('category_id'));
    }

    /**
     * Returns case data as array from request
     *
     * @param Request $request
     * @return array
     */
    private function getCaseDataFromRequest(Request $request)
    {
        return [
            'virtual_slide_provider_id' => $request->get('virtual_slide_provider_id'),
            'clinical_data'             => $request->get('clinical_data'),
            'category_id'               => $request->get('category_id')
        ];

    }

    /**
     * Returns slide data as array from Request
     *
     * @param Request $request
     * @return array
     */
    private function getSlideDataFromRequest(Request $request)
    {
        $slideData = [];
        for ($i = 0; $i < count($request->get('url')); $i++) {
            $slideData[] = [
                'url'   => $request->get('url')[$i],
                'stain' => $request->get('stain')[$i]
            ];
        }
        return $slideData;
    }


}
