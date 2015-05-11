<?php  namespace Kivi\Repositories;

use App\Category;

class CategoryRepository
{

    public function find($id)
    {
        return Category::find($id);
    }

    public function all()
    {
        $categories = [];
        $tmp = Category::select('parent_id', 'category', 'id')
                            ->orderBy('parent_id')
                            ->get();
        foreach($tmp as $category) {
            $parentId = $category->parent_id ?: 0;
            $categories[$parentId][] = [
                'id'       => $category->id,
                'category' => $category->category
            ];
        }
        return $categories;
    }

    public function parents($id)
    {
        $parents = [];
        /** @var Category $category */
        $category = Category::find($id);
        $parent = $category->parent;
        while($parent) {
            array_unshift($parents, [
                'id'       => $parent->id,
                'category' => $parent->category
            ]);
            $parent = $parent->parent;
        }
        return $parents;
    }

    public function create($input)
    {
        return Category::create($input);
    }

    public function topLevelCategories()
    {
        return Category::where(['parent_id' => null])->get();
    }
}