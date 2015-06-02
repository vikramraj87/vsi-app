<?php namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Kivi\Repositories\CategoryRepository;

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
    }

    /**
     * Shows the subcategories of selected category and provides form
     * for editing or deleting the category
     *
     * @param int $id      Selected category
     * @return \Illuminate\View\View
     */
    public function index($id = 0)
    {
        $categories = $this->categoryRepository->all();
        return response()->jsend('success', $categories);
    }

    /**
     * Creates a new category record
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'parent_id' => 'required|integer',
            'category'  => 'required|string|unique_with:categories,parent_id'
        ]);

        if($validator->fails()) {
            return response()->jsend('fail', [
                'reason' => 'ValidationFailed',
                'errors' => $validator->errors()->all()
            ]);
        }

        $data = [
            'parent_id' => $request->get('parent_id') == 0 ? null : $request->get('parent_id'),
            'category'  => $request->get('category')
        ];

        $savedCategory = $this->categoryRepository->create($data);

        if($savedCategory->exists('id')) {
            return response()->jsend('success', $savedCategory->toArray());
        }

        return response()->jsend('fail');
    }

    /**
     * Updates a category record identified by the id hidden field
     *
     * @param Requests\UpdateCategoryRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Requests\UpdateCategoryRequest $request)
    {
        $id       = $request->get('id');
        $parentId = $request->get('parent_id');

        $category           = $this->categoryRepository->find($id);
        $category->category = $request->get('category');
        $result = $category->save();

        // todo: Handle $result = false

        return redirect()->route('category-index', $parentId);
    }

    /**
     * Deletes the category record
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function destroy($id)
    {
        /** @var Category $category */
        $category = $this->categoryRepository->find($id);
        $redirectUrl = $category->parent_id == null ?
                            'categories' : 'categories/' . $category->parent_id;
        $category->delete();
        return redirect($redirectUrl);
    }

    public function check($parentId = 0, $categoryName = "")
    {
        if(0 === $parentId || "" === $categoryName) {
            return response()->jsend('success');
        }
        $category = $this->categoryRepository->fetchByParentIdAndCategory($parentId, $categoryName);
        if(null === $category) {
            return response()->jsend('success');
        }
        return response()->jsend('fail', [
            'reason' => 'CategoryAlreadyExists',
            'category' => $category
        ]);
    }
}
