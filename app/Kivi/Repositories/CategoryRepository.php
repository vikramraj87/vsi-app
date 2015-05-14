<?php  namespace Kivi\Repositories;

use App\Category;

class CategoryRepository
{

    public function find($id)
    {
        return Category::find($id);
    }

    public function parents($id)
    {
        $parents = [];
        /** @var Category $category */
        $category = Category::find($id);
        $parent = $category->parent;
        while($parent) {
            array_unshift($parents, $parent);
            $parent = $parent->parent;
        }
        return $parents;
    }

    /**
     * Returns an array containing the ids of children, grand children
     * of the category identified by the parentId
     *
     * @param $parentId
     * @return array
     */
    public function hierarchicalCategoryIds($parentId)
    {
        $parentId = $parentId ?: null;
        $categoryIds = [];

        if(!is_null($parentId)) {
            $categoryIds[] = $parentId;
        }

        for(
            $tmp = [],$categories = Category::where('parent_id', $parentId)->get();
            count($categories)>0;
            $categories=Category::whereIn('parent_id', $tmp)->get(), $tmp = []
        )
        {
            foreach($categories as $category) {
                $tmp[] = $categoryIds[] = $category->id;
            }
        }
        return $categoryIds;
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