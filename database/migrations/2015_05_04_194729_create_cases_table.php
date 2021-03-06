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

            // Unique category and parent_id
            $table->unique(['category', 'parent_id']);
        });

        // Create virtual slide providers table
        Schema::create('virtual_slide_providers', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('url');
            $table->timestamps();
        });

        // Create cases table
		Schema::create('cases', function(Blueprint $table)
		{
			$table->increments('id');
            $table->text('clinical_data')->nullable();
            $table->integer('category_id')->unsigned()->nullable();
            $table->integer('virtual_slide_provider_id')->unsigned()->nullable();
			$table->timestamps();

            $table->foreign('category_id')
                  ->references('id')
                  ->on('categories')
                  ->onDelete('set null');

            $table->foreign('virtual_slide_provider_id')
                  ->references('id')
                  ->on('virtual_slide_providers')
                  ->onDelete('cascade');
        });

        // Create virtual slides table
        Schema::create('virtual_slides', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('url')->unique();
            $table->string('stain', 50);
            $table->text('remarks')->nullable();
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
        Schema::drop('virtual_slide_providers');
        Schema::drop('categories');
	}

}
