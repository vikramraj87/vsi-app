<?php namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Kivi\Repositories\CategoryRepository;

class CategoryController extends Controller {

    /** @var CategoryRepository */
    private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function index(Request $request)
    {
        $edit = intval($request->get('edit', '0'));
        $subCategories = $this->categoryRepository->topLevelCategories();
        return view('category.index', compact('edit', 'subCategories'));
    }

    public function show(Request $request, $id = 0)
    {
        $edit = intval($request->get('edit', 0));
        if($id > 0) {
            $category = $this->categoryRepository->find($id);
            $subCategories = $category->subCategories;
            $parents = $this->categoryRepository->parents($category->id);
        } else {
            $category = null;
            $parents = null;
            $subCategories = $this->categoryRepository->topLevelCategories();
        }
        return view('category.index', compact('edit', 'category', 'parents', 'subCategories'));
    }

    public function create()
    {
        return view('category.create', ['categories' => $this->categoryRepository->allWithRelations()]);
    }

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

    public function update(Requests\UpdateCategoryRequest $request)
    {
        return $request->all();
    }

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
