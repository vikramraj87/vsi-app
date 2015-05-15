<?php  namespace Kivi\Repositories;

use App\VirtualCase;
use App\VirtualSlide;

class CaseRepository
{
    public function find($id)
    {
        return VirtualCase::with('slides', 'provider', 'category')->find($id);
    }

    public function create($caseData, $slideData)
    {
        $case = new VirtualCase($caseData);

        if($case->save()) {
            $slides = $this->createSlides($slideData, $case);
            return $case->slides()->saveMany($slides);
        }
        return false;
    }

    public function update($id, $caseData, $slideData)
    {
        $case = $this->find($id);

        if($case->update($caseData)) {
            $slides = $this->createSlides($slideData, $case);
            $case->slides()->delete();
            return $case->slides()->saveMany($slides);
        }
        return false;
    }

    public function casesByCategories($categoryIds)
    {
        $cases =  VirtualCase::whereIn('category_id', $categoryIds)->get();
        $cases->load('slides', 'provider');
        return $cases;
    }

    /**
     * @param $slideData
     * @param $case
     */
    private function createSlides($slideData, $case)
    {
        $slides = [];
        foreach ($slideData as $data) {
            $slide = new VirtualSlide($data);
            $slide->case_id = $case->id;
            $slides[] = $slide;
        }
        return $slides;
    }
} 