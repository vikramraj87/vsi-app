<?php  namespace Kivi\Repositories;

use App\Category;

class CategoryRepository
{

    public function find($id)
    {
        return Category::find($id);
    }

    public function allWithRelations()
    {
        $categories = [];

        $topLevelCategories = Category::where(["parent_id" => null])->get();
        foreach($topLevelCategories as $topLevelCategory) {
            $categories = $categories + $this->recursive($topLevelCategory);
        }

        return $categories;
    }

    public function create($input)
    {
        return Category::create($input);
    }

    private function recursive(Category $category, $prefix = "", $separator = "&raquo;")
    {
        $categories = [];

        $subCategories = $category->subCategories;

        if($prefix != "") {
            $prefix = $prefix . " " . $separator . " ";
        }

        $definition = $prefix . $category->category;
        $categories[$category->id] = $definition;
        if(count($subCategories)) {
            foreach ($subCategories as $subCategory) {
                $categories = $categories + $this->recursive($subCategory, $prefix . $category->category);
            }
        }
        return $categories;
    }
}