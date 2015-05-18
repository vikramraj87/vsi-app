<?php  namespace Kivi\Repositories;

use App\VirtualCase;
use App\VirtualSlide;
use Illuminate\Database\Eloquent\Collection;

class CaseRepository
{
    /**
     * Finds a specific record
     *
     * @param $id
     * @return VirtualCase
     */
    public function find($id)
    {
        return VirtualCase::with('slides', 'provider', 'category')->find($id);
    }

    /**
     * Creates a new record
     *
     * @param $caseData
     * @param $slideData
     * @return array|bool
     */
    public function create($caseData, $slideData)
    {
        $case = new VirtualCase($caseData);

        if($case->save()) {
            $slides = $this->createSlides($slideData, $case);
            return $case->slides()->saveMany($slides);
        }
        return false;
    }

    /**
     * Updates the record
     *
     * @param $id
     * @param $caseData
     * @param $slideData
     * @return bool
     */
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

    /**
     * Returns cases belonging to the categories identified by categoryIds array
     *
     * @param $categoryIds
     * @return Collection
     */
    public function casesByCategories($categoryIds)
    {
        $cases =  VirtualCase::whereIn('category_id', $categoryIds)->get();
        $cases->load('slides', 'provider', 'category');
        return $cases;
    }

    /**
     * Creates array of slides belonging to a particular
     * case from data
     *
     * @param $slideData
     * @param $case
     * @return array
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