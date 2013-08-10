<?php

use Illuminate\Database\Migrations\Migration;

class CreateStoriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// Create the Stories table
		Schema::create('stories', function($table){
			$table->increments('id');
			$table->string('team');
			$table->string('source');
			$table->string('hash');
			$table->timestamps();
			$table->text('story');
			$table->string('type');

			$table->unique(array('team','hash'));
			// $table->string('keywords');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		// Drop Stories table
		Schema::drop('stories');
	}

}