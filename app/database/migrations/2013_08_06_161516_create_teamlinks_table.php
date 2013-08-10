<?php

use Illuminate\Database\Migrations\Migration;

class CreateTeamlinksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// Create the Teamlinks table
		Schema::create('teamlinks', function($table){
			$table->increments('id');
			$table->string('team');
			$table->string('link')->unique();
			$table->string('parser');
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
		// Drop the Teamlinks table
		Schema::drop('teamlinks');
	}

}