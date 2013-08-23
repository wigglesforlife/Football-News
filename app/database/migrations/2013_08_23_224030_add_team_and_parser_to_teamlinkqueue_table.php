<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddTeamAndParserToTeamlinkqueueTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('teamlinkqueue', function(Blueprint $table) {
			$table->string('team');
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
		Schema::table('teamlinkqueue', function(Blueprint $table) {
			$table->dropColumn('team');
			$table->dropColumn('parser');
		});
	}

}
