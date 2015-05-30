<?php namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests;
use App\Http\Controllers\Controller;

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
     * @param Requests\CreateCategoryRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Requests\CreateCategoryRequest $request)
    {
        $data = [
            'parent_id' => $request->get('parent_id') == 0 ? null : $request->get('parent_id'),
            'category'  => $request->get('category')
        ];
        $this->categoryRepository->create($data);

        $redirectUrl = $data['parent_id'] == null ? 'categories' : 'categories/' . $data['parent_id'];
        return redirect($redirectUrl);
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
}
