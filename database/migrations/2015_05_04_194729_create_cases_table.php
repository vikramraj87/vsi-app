<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCasesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        // Create categories table
        Schema::create('categories', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('category');
            $table->integer('parent_id')->unsigned()->nullable();
            $table->timestamps();

            // Parent child relationship
            $table->foreign('parent_id')
                ->references('id')
                ->on('categories')
                ->onDelete('cascade');
        });

        // Create cases table
		Schema::create('cases', function(Blueprint $table)
		{
			$table->increments('id');
            $table->text('clinical_data');
            $table->string('diagnosis');
            $table->integer('category_id')->unsigned()->nullable();
			$table->timestamps();

            $table->foreign('category_id')
                  ->references('id')
                  ->on('categories');
                  // TODO: Look for option to make the category id null when a category is deleted
		});

        // Create virtual slides table
        Schema::create('virtual_slides', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('url');
            $table->string('stain', 50);
            $table->integer('x');
            $table->integer('y');
            $table->integer('case_id')->unsigned();
            $table->timestamps();

            $table->foreign('case_id')
                ->references('id')
                ->on('cases')
                ->onDelete('cascade');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::drop('virtual_slides');
		Schema::drop('cases');
        Schema::drop('categories');
	}

}
