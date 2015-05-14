<?php  namespace Kivi\Repositories;

use App\VirtualCase;
use App\VirtualSlide;

class CaseRepository
{
    public function find($id)
    {
        return VirtualCase::find($id);
    }

    public function create($caseData, $slideData)
    {
        $case = new VirtualCase;
        $case->virtual_slide_provider_id = $caseData['virtual_slide_provider_id'];
        $case->clinical_data             = $caseData['clinical_data'];
        $case->category_id               = $caseData['category_id'];

        if($case->save()) {
            $slides = [];
            foreach($slideData as $data) {
                $slide = new VirtualSlide();
                $slide->url     = $data['url'];
                $slide->stain   = $data['stain'];
                $slide->case_id = $case->id;
                $slides[] = $slide;
            }
            return $case->slides()->saveMany($slides);
        }
        return false;
    }

    public function casesByCategories($categoryIds)
    {
        $cases =  VirtualCase::whereIn('category_id', $categoryIds)->get();
        $cases->load('slides');
        return $cases;
    }
} 