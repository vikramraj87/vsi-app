<?php namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class AdminController extends Controller {
    public function newCategory()
    {
        $categories = [];

        $topLevelCategories = Category::where(["parent_id" => null])->get();
        foreach($topLevelCategories as $topLevelCategory) {
            $categories = $categories + $this->recursive($topLevelCategory);
        }

        return view("admin.new-category", ["categories" => $categories]);
    }

    public function store()
    {

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
