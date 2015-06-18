<?php namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Kivi\Repositories\CategoryRepository;

use Kivi\Services\Response\Jsend\Failure\Failure400;
use Kivi\Services\Response\Jsend\Failure\Failure409;
use Kivi\Services\Response\Jsend\Failure\Failure404;

use Kivi\Services\Response\Jsend\Success\Success201;
use Kivi\Services\Response\Jsend\Success\Success200;


class CategoryController extends Controller {

    /** @var CategoryRepository */
    private $categoryRepository;

    /**
     * Constructor.
     *
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
        $this->middleware('atleast_moderator', ['except' => 'index']);
    }

    /**
     * Shows the subcategories of selected category and provides form
     * for editing or deleting the category
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $categories = $this->categoryRepository->all();
        return response()->jsend(new Success200($categories->toArray()));
    }

    public function show($id)
    {
        $id = intval($id);
        $category = $this->categoryRepository->find($id);
        if(null === $category) {
            return response()->jsend(new Failure404($id));
        }
        return response()->jsend(new Success200($category->toArray()));
    }

    /**
     * Creates a new category record
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $validator = $this->validator($request);

        if($validator->fails()) {
            return response()->jsend(new Failure400($validator->errors()->all()));
        }

        $data = [
            'parent_id' => $request->get('parent_id') == 0 ? null : intval($request->get('parent_id')),
            'category'  => $request->get('category')
        ];

        $exists = $this->categoryRepository->fetchByParentIdAndCategory($data['parent_id'], $data['category']);
        if(count($exists)) {
            return response()->jsend(new Failure409());
        }

        $savedCategory = $this->categoryRepository->create($data);

        if($savedCategory->exists('id')) {
            return response()->jsend(new Success201($savedCategory->toArray()));
        }

        return response()->jsend(new Failure400([]));
    }

    /**
     * Updates a category record identified by the id hidden field
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $id = intval($id);
        $category = $this->categoryRepository->find($id);

        if(null === $category) {
            return response()->jsend(new Failure404($id));
        }

        $validator = $this->validator($request, $id);

        if($validator->fails()) {
            return response()->jsend(new Failure400($validator->errors()->all()));
        }

        $exists = $this->categoryRepository->fetchByParentIdAndCategory($request->get('parent_id'), $request->get('category'));
        if($exists && $exists->id !== $id) {
            return response()->jsend(new Failure409());
        }

        $category->parent_id = $request->get('parent_id') == 0 ? null : intval($request->get('parent_id'));
        $category->category = $request->get('category');

        $result = $this->categoryRepository->update($category);

        if(false === $result) {
            return response()->jsend(new Failure400());
        }

        return response()->jsend(new Success200($category->toArray()));
    }

    public function check($parentId = 0, $categoryName = "", $exclude = 0)
    {
        if(0 === $parentId || "" === $categoryName) {
            return response()->jsend(new Success200());
        }
        $exclude = intval($exclude);
        $category = $this->categoryRepository->fetchByParentIdAndCategory($parentId, $categoryName);
        if(null === $category || $category->id === $exclude) {
            return response()->jsend(new Success200());
        }
        return response()->jsend(new Failure409());
    }

    /**
     * @param Request $request
     * @param integer $id
     * @return mixed
     */
    private function validator(Request $request, $id = 0)
    {
        $validator = Validator::make($request->all(), [
            'parent_id' => 'required|integer|exists:categories,id',
            'category' => 'required|string'
        ]);

        $validator->after(function($validator) use($request, $id) {
            if($request->get('parent_id') == $id) {
                $validator->errors()->add('parent_id', 'A category cannot be a parent for itself');
            }
        });

        return $validator;
    }
}
