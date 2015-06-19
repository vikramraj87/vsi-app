<?php

use  Laracasts\Integrated\Services\Laravel\DatabaseTransactions;


class CategoryApiTest extends IntegratedTestCase
{
    use DatabaseTransactions;

	/** @test */
    function it_should_fetch_all_categories()
    {
    	$this->get('api/categories')
            ->seeStatusCodeIs(200)
			->seeJsonContains(['status' => 'success']);
	}

	/** @test */
	function it_should_not_authorize_a_guest_fetching_a_single_category()
	{
		$this->get('api/categories/5')
			->seeStatusCodeIs(401)
			->seeJsonEquals(['status' => 'fail', 'data' => ['reason' => 'Unauthorized']]);
	}

	/** @test */
	function it_should_not_authorize_a_user_fetching_a_single_category()
	{
		$this->be($this->mockUser());

		$this->get('api/categories/5')
			->seeStatusCodeIs(401)
			->seeJsonEquals(['status' => 'fail', 'data' => ['reason' => 'Unauthorized']]);
	}

    /** @test */
    function it_should_display_404_when_trying_to_get_non_exitent_category()
    {
        $this->be($this->mockModerator());

        $this->get('api/categories/5001')
            ->seeStatusCodeIs(404)
            ->seeJsonEquals(['status' => 'fail', 'data' => ['reason' => 'NotFound', 'id' => 5001]]);
    }
    /** @test */
	function it_should_allow_a_moderator_fetching_a_single_category()
	{
		$this->be($this->mockModerator());

		$this->get('api/categories/5')
			->seeStatusCodeIs(200)
			->seeJsonContains(['status' => 'success'])
			->seeJsonContains(['id' => 5]);
	}

	/** @test */
	function it_should_allow_a_admin_fetching_a_single_category()
	{
		$this->be($this->mockAdmin());


		$this->get('api/categories/5')
			->seeStatusCodeIs(200)
			->seeJsonContains(['status' => 'success'])
			->seeJsonContains(['id' => 5]);
	}

	/** @test */
	function it_should_not_allow_a_guest_to_create_a_category()
	{
		$this->post('api/categories', [])
			->seeStatusCodeIs(401)
			->seeJsonEquals(['status' => 'fail', 'data' => ['reason' => 'Unauthorized']]);
	}

	/** @test */
	function it_should_not_allow_an_user_to_create_a_category()
	{
		$this->be($this->mockUser());

		$this->post('api/categories', [])
			->seeStatusCodeIs(401)
			->seeJsonEquals(['status' => 'fail', 'data' => ['reason' => 'Unauthorized']]);
	}

	/** @test */
	function it_should_not_allow_a_category_to_be_created_with_empty_data()
	{
			$this->be($this->mockModerator());

			$this->post('api/categories', [])
				->seeStatusCodeIs(400)
				->seeJsonContains(['status' => 'fail'])
				->seeJsonContains(['reason' => 'ValidationFailed']);
    }

    /** @test */
	function it_should_not_allow_a_category_to_be_created_with_incomplete_data()
	{
			$this->be($this->mockModerator());

			$this->post('api/categories', ['category' => 'Fat necrosis', 'parent_id' => 0])
				->seeStatusCodeIs(400)
				->seeJsonContains(['status' => 'fail'])
				->seeJsonContains(['reason' => 'ValidationFailed']);
	}

    /** @test */
	function it_should_not_allow_a_category_to_be_created_with_duplicate_data()
	{
			$this->be($this->mockModerator());

			$this->post('api/categories', ['category' => 'Fat necrosis', 'parent_id' => 8])
				->seeStatusCodeIs(409)
				->seeJsonContains(['status' => 'fail'])
				->seeJsonContains(['reason' => 'DuplicateEntry']);
    }

    /** @test */
	function it_should_not_allow_a_category_to_be_created_with_invalid_parent_id()
	{
			$this->be($this->mockModerator());

			$this->post('api/categories', ['category' => 'Fat necrosis', 'parent_id' => 10001])
				->seeStatusCodeIs(400)
				->seeJsonContains(['status' => 'fail'])
				->seeJsonContains(['reason' => 'ValidationFailed']);
	}

    /** @test */
	function it_should_not_allow_a_category_to_be_created_with_invalid_name()
	{
			$this->be($this->mockModerator());

			// Create a category with invalid name
			// todo: Implement testing
			//
	}

    /** @test */
    function it_should_create_a_new_category_when_valid_data_and_permissions_are_provided()
    {
        $this->be($this->mockAdmin());

        $data = ['category' => 'Respiratory Tract', 'parent_id' => 1];
        $this->post('api/categories', $data)
            ->seeStatusCodeIs(201)
            ->verifyInDatabase('categories', $data)
            ->seeJsonContains(['status' => 'success'])
            ->seeJsonContains(['category' => 'Respiratory Tract']);
    }

    /** @test */
    function it_should_not_allow_a_guest_to_edit_a_category()
    {
        $this->put('api/categories/2', [])
        	->seeStatusCodeIs(401)
        	->seeJsonContains(['status' => 'fail']);
    }

    /** @test */
    function it_should_not_allow_an_user_to_edit_a_category()
    {
    	$this->be($this->mockUser());

    	$this->put('api/categories/2', [])
        	->seeStatusCodeIs(401)
        	->seeJsonContains(['status' => 'fail']);
    }

    /** @test */
    function it_should_display_404_when_trying_to_edit_a_non_existing_category()
    {
    	$this->be($this->mockModerator());

        $this->put('api/categories/5001', [])
            ->seeStatusCodeIs(404)
            ->seeJsonEquals(['status' => 'fail', 'data' => ['reason' => 'NotFound', 'id' => 5001]]);
    }

    /** @test */
    function it_should_not_allow_a_moderator_or_admin_to_edit_with_empty_data()
    {
    	$this->be($this->mockModerator());

        $this->put('api/categories/2', [])
    		->seeStatusCodeIs(400)
    		->seeJsonContains(['status' => 'fail'])
    		->seeJsonContains(['reason' => 'ValidationFailed']);
    }

    /** @test */
    function it_should_not_allow_a_moderator_or_admin_to_edit_without_parent_id()
    {
    	$this->be($this->mockModerator());

        $this->put('api/categories/2', ['category' => 'Histopathology', 'parent_id' => 0])
            ->seeStatusCodeIs(400)
            ->seeJsonContains(['status' => 'fail'])
            ->seeJsonContains(['reason' => 'ValidationFailed']);
    }

    /** @test */
    function it_should_not_allow_a_moderator_or_admin_to_edit_with_invalid_parent_id()
    {
    	$this->be($this->mockModerator());

        $this->put('api/categories/2', ['category' => 'Histopathology', 'parent_id' => 10001])
            ->seeStatusCodeIs(400)
            ->seeJsonContains(['status' => 'fail'])
            ->seeJsonContains(['reason' => 'ValidationFailed']);
    }

    /** @test */
    function it_should_not_allow_a_moderator_or_admin_to_edit_with_duplicate_data()
    {
    	$this->be($this->mockModerator());

        $this->put('api/categories/2', ['category' => 'Nipple adenoma', 'parent_id' => 10])
              ->seeStatusCodeIs(409)
            ->seeJsonContains(['status' => 'fail'])
            ->seeJsonContains(['reason' => 'DuplicateEntry']);
    }

    /** @test */
    function it_should_not_allow_a_moderator_or_admin_to_edit_with_parent_id_same_as_id()
    {
    	$this->be($this->mockModerator());

        $this->put('api/categories/2', ['category' => 'Hematopathology', 'parent_id' => 2])
            ->seeStatusCodeIs(400)
            ->seeJsonContains(['status' => 'fail'])
            ->seeJsonContains(['reason' => 'ValidationFailed']);

        // Create a category with invalid name
        // todo: Implement testing
        //
    }

    /** @test */
    function it_should_not_allow_a_moderator_or_admin_to_edit_with_invalid_name()
    {
        $this->be($this->mockModerator());

        // Create a category with invalid name
        // todo: Implement testing
        //
    }

    /** @test */
    function it_should_allow_moderator_or_admin_to_edit_a_category_with_valid_details()
    {
        $this->be($this->mockAdmin());

        $data = ['category' => 'Duct Ectasia', 'parent_id' => 5];
        $this->put('api/categories/6', $data)
            ->seeStatusCodeIs(200)
            ->verifyInDatabase('categories', $data)
            ->seeJsonContains(['status' => 'success'])
            ->seeJsonContains(['id' => 6])
            ->seeJsonContains(['category' => 'Duct Ectasia']);
    }

    /** @test */
    function it_should_allow_a_moderator_or_admin_to_save_a_category_with_the_same_name()
    {
        $this->be($this->mockAdmin());

        $data = ['category' => 'Mammary duct ectasia', 'parent_id' => 5];
        $this->put('api/categories/6', $data)
            ->seeStatusCodeIs(200)
            ->verifyInDatabase('categories', $data)
            ->seeJsonContains(['status' => 'success'])
            ->seeJsonContains(['id' => 6])
            ->seeJsonContains(['category' => 'Mammary duct ectasia']);
    }

    /** @test */
    function it_should_not_allow_a_guest_or_an_user_to_check_for_existence_of_category()
    {
        $this->get('api/categories/check-existence/1/Breast')
            ->seeStatusCodeIs(401)
            ->seeJsonContains(['status' => 'fail']);

        $this->be($this->mockUser());
        $this->get('api/categories/check-existence/1/Breast')
            ->seeStatusCodeIs(401)
            ->seeJsonContains(['status' => 'fail']);
    }

    /** @test */
    function it_should_allow_a_moderator_to_check_existence_of_category()
    {
        $this->be($this->mockModerator());
        $this->get('api/categories/check-existence/1/Breast')
            ->seeStatusCodeIs(409)
            ->seeJsonContains(['status' => 'fail'])
            ->seeJsonContains(['reason' => 'DuplicateEntry']);
    }

    /** @test */
    function it_should_allow_a_moderator_to_check_existence_of_category_while_excluding_current_category()
    {
        $this->be($this->mockModerator());
        $this->get('api/categories/check-existence/1/Breast/4')
            ->seeStatusCodeIs(200)
            ->seeJsonEquals(['status' => 'success', 'data' => []]);
    }

    /** @test */
    function it_should_allow_a_moderator_to_check_existence_of_non_existent_category()
    {
        $this->be($this->mockModerator());
        $this->get('api/categories/check-existence/2/Breast')
            ->seeStatusCodeIs(200)
            ->seeJsonEquals(['status' => 'success', 'data' => []]);
    }
}
