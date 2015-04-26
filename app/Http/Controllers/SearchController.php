<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Kivi\CountBasedMerger;
use Kivi\Providers\Leeds;
use Kivi\Providers\RosaiCollection;

class SearchController extends Controller {

    public function index($term, Leeds $leeds, RosaiCollection $rosai)
    {
        $leedsResults = $leeds->search($term);
        $rosaiResults = $rosai->search($term);
        $results = CountBasedMerger::merge($rosaiResults, $leedsResults);
        return view("search", ["cases" => $results]);
    }

}
