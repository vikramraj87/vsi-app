<?php 

use Laracasts\Integrated\Services\Laravel\DatabaseTransactions;

class CaseApiTest extends IntegratedTestCase {
    use DatabaseTransactions;

    /** @test */
    function it_should_pass()
    {
        $this->assertTrue(true);
    }
//    /** @test */
//    function it_should_allow_anyone_to_fetch_all_cases()
//    {
//        $this->get('api/cases')
//            ->seeStatusCodeIs(200)
//            ->seeJsonContains(['status' => 'success']);
//    }
//
//    /** @test */
//    function it_should_allow_anyone_to_fetch_cases_by_categories()
//    {
//        $this->get('api/cases/category/1')
//            ->seeStatusCodeIs(200)
//            ->seeJsonContains(['status' => 'success']);
//    }
//
//    /** @test */
//    function it_should_not_allow_a_guest_to_fetch_a_single_case()
//    {
//        $this->get('api/cases/2')
//            ->seeStatusCodeIs(401)
//            ->seeJsonContains(['status' => 'fail'])
//            ->seeJsoNContains(['reason' => 'Unauthorized']);
//    }
//
//    /** @test */
//    function it_should_not_allow_an_user_to_fetch_a_single_case()
//    {
//        $this->be($this->mockUser());
//
//        $this->get('api/cases/2')
//            ->seeStatusCodeIs(401)
//            ->seeJsonContains(['status' => 'fail'])
//            ->seeJsoNContains(['reason' => 'Unauthorized']);
//    }
//
//    /** @test */
//    function it_should_allow_a_moderator_to_fetch_a_single_case()
//    {
//        $this->be($this->mockModerator());
//
//        $this->get('api/cases/2')
//            ->seeStatusCodeIs(200)
//            ->seeJsonContains(['status' => 'success'])
//            ->seeJsonContains(['id' => 2]);
//    }
//
//    /** @test */
//    function it_should_allow_an_admin_to_fetch_a_single_case()
//    {
//        $this->be($this->mockAdmin());
//
//        $this->get('api/cases/2')
//            ->seeStatusCodeIs(200)
//            ->seeJsonContains(['status' => 'success'])
//            ->seeJsonContains(['id' => 2]);
//    }
//
//    /** @test */
//    function it_should_not_allow_a_guest_to_create_a_new_case()
//    {
//        $this->post('api/cases', [])
//            ->seeStatusCodeIs(401)
//            ->seeJsonContains(['status' => 'fail'])
//            ->seeJsonContains(['reason' => 'Unauthorized']);
//    }
//
//    /** @test */
//    function it_should_not_allow_an_user_to_create_a_new_case()
//    {
//        $this->be($this->mockUser());
//
//        $this->post('api/cases', [])
//            ->seeStatusCodeIs(401)
//            ->seeJsonContains(['status' => 'fail'])
//            ->seeJsonContains(['reason' => 'Unauthorized']);
//    }
//
//    /** @test */
//    function it_should_not_allow_a_moderator_to_create_an_invalid_case()
//    {
//        $this->be($this->mockModerator());
//
//
//    }
} 