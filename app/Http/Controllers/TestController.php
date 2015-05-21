<?php namespace App\Http\Controllers;

use App\Category;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index()
    {
        return view('test.test');
    }

    public function categories()
    {
        $categories = Category::all();
        return $categories;
    }
}
