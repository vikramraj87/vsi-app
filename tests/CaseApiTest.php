<?php 
class CaseApiTest extends TestCase
{
    /** @test */
    public function it_fetches_all_cases_belonging_to_category()
    {
        $this->get('/cases/category/7')
            ->seeJson();

    }
} 