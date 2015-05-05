<?php namespace App\Http\Controllers;

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

    public function create()
    {
        return view('category.create', ['categories' => $this->categoryRepository->allWithRelations()]);
    }

    public function store(Requests\CreateCategoryRequest $request)
    {
        $data = [
            'parent_id' => $request->get('parent_id'),
            'category'  => $request->get('category')
        ];

        $this->categoryRepository->create($data);

        return redirect('categories/create');
    }
}
