<?php namespace App\Http\Controllers;

use App\Http\Requests;

use Illuminate\Http\Request;

use App\VirtualCase;
use Illuminate\Support\Facades\Validator;
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

        $this->middleware('atleast_moderator', ['except' => 'index']);
    }

    /**
     * Returns all cases belonging to a category. If 0 provided as category id,
     * returns all cases in the database.
     *
     * @param Request $request
     * @param int $parentId
     * @return mixed
     */
    public function index(Request $request, $parentId = 0)
    {
        $parentId = intval($parentId);
        $category = $this->categoryRepository->find($parentId);

        if(null === $category && $parentId !== 0) {
            return response()->jsend('fail', [
                'reason' => 'CategoryNotFound',
                'id' => $parentId
            ]);
        }

        $hierarchicalCategories = $this->categoryRepository->hierarchicalCategoryIds($parentId);
        $cases                  = $this->caseRepository->casesByCategories($hierarchicalCategories);

        return response()->jsend('success', $cases);
    }

    /**
     * Return a single case
     *
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        $case = $this->caseRepository->find($id);

        if(null === $case) {
            return response()->jsend('fail', [
                'reason' => 'CaseNotFound',
                'id' => $id
            ]);
        }

        return response()->jsend('success', $case);
    }

    /**
     * Store a single case in the database after validation
     *
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        $validator = $this->getValidator($request);

        if($validator->fails()) {
            return response()->jsend('fail', [
                'reason' => 'ValidationFailed',
                'errors' => $validator->errors()->all()
            ]);
        }

        $caseData  = $this->getCaseDataFromRequest($request);
        $slideData = $this->getSlideDataFromRequest($request);

        $result = $this->caseRepository->create($caseData, $slideData);

        if($result) {
            return response()->jsend('success');
        }
        return response()->jsend('fail');
    }

    /**
     * Updates a single record after validation
     *
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function update(Request $request, $id)
    {
        $id = intval($id);
        $case = $this->caseRepository->find($id);
        if(null === $case) {
            return response()->jsend('fail', [
                'reason' => 'CaseNotFound',
                'id' => $id
            ]);
        }

        $validator = $this->getValidator($request);

        if($validator->fails()) {
            return response()->jsend('fail', [
                'reason' => 'ValidationFailed',
                'errors' => $validator->errors()->all()
            ]);
        }

        $caseData  = $this->getCaseDataFromRequest($request);
        $slideData = $this->getSlideDataFromRequest($request);

        $result = $this->caseRepository->update($case, $caseData, $slideData);

        if($result) {
            return response()->jsend('success');
        }
        return response()->jsend('fail');
    }

    /**
     * Deletes a single record
     *
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function destroy(Request $request, $id)
    {
        $id = intval($id);

        /** @var VirtualCase $case */
        $case = $this->caseRepository->find($id);

        if(null === $case) {
            return response()->jsend('fail', [
                'reason' => 'CaseNotFound',
                'id' => $id
            ]);
        }

        // Delete the slides of the case
        $case->slides()->delete();

        // Delete the case itself
        $case->delete();

        return response()->jsend('success');
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
                'stain' => $request->get('stain')[$i],
                'remarks' => $request->get('remarks')[$i]
            ];
        }
        return $slideData;
    }

    private function getValidator(Request $request)
    {
        return Validator::make($request->all(), $this->getValidationRules($request));
    }

    private function getValidationRules(Request $request)
    {
        $rules = [
            'virtual_slide_provider_id' => 'required|integer|exists:virtual_slide_providers,id',
            'clinical_data' => 'string',
            'category_id' => 'required|integer|exists:categories,id'
        ];

        $urlRule = 'required|url|unique:virtual_slides,url,';
        $stainRule = 'required';
        $remarksRule = 'string';

        if(! is_array($request->get('url'))) {
            $rules['url.0'] = $urlRule;
            $rules['stain.0'] = $stainRule;
            $rules['remarks.0'] = $remarksRule;

            return $rules;
        }
        foreach ($request->get('url') as $key => $val) {
            $exceptId = $request->exists('slide_id') ? $request->get('slide_id')[$key] : '';
            $rules['url.' . $key] = $urlRule . $exceptId;
        }

        foreach ($request->get('stain') as $key => $val) {
            $rules['stain.' . $key] = $stainRule;
        }

        foreach ($request->get('remarks') as $key => $val) {
            $rules['remarks.' . $key] = $remarksRule;
        }

        return $rules;
    }
}
