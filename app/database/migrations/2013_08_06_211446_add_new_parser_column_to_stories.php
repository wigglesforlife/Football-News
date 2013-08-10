<?php

use Illuminate\Database\Migrations\Migration;

class AddNewParserColumnToStories extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// Add the parser column
		Schema::table('stories', function($table){
			$table->string('parser');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		// Drop the parser column
		Schema::table('stories', function($table){
			$table->dropColumn('parser');
		});
	}

}