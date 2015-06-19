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

        $data = $request->only(['parent_id', 'category']);

        if($this->exists($data['parent_id'], $data['category'])) {
            return response()->jsend(new Failure409());
        }

        $savedCategory = $this->categoryRepository->create($data);
        if($savedCategory->exists('id')) {
            return response()->jsend(new Success201($savedCategory->toArray()));
        }

        return response()->jsend(new Failure400([]));
    }

    /**
     * Updates a category record
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

        $data = $request->only(['category', 'parent_id']);

        if($this->exists($data['parent_id'], $data['category'], $id)) {
            return response()->jsend(new Failure409());
        }

        $category->parent_id = $data['parent_id'];
        $category->category = $data['category'];

        $result = $this->categoryRepository->update($category);

        if(false === $result) {
            return response()->jsend(new Failure400());
        }

        return response()->jsend(new Success200($category->toArray()));
    }

    public function check($parentId = 0, $categoryName = "", $exclude = 0)
    {
        return $this->exists($parentId, $categoryName, $exclude) ?
            response()->jsend(new Failure409()) : response()->jsend(new Success200());
    }

    private function exists($parent_id, $category, $exclude = 0)
    {
        $parent_id = intval($parent_id);
        if(0 === $parent_id || "" === $category) {
            return false;
        }

        $category = $this->categoryRepository->fetchByParentIdAndCategory($parent_id, $category);
        if(null === $category) {
            return false;
        }

        $exclude = intval($exclude);
        if($exclude && $category->id === $exclude) {
            return false;
        }

        return true;
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
