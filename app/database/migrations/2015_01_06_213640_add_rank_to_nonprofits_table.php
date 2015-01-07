<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRankToNonprofitsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * How to make migration on a table
	 * artisan migrate:make add_votes_to_user_table --table=users
	 * 
	 * @return void
	 */
	public function up()
	{
		Schema::table('nonprofits', function(Blueprint $table)
		{
			//
			$table->integer('rank');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('nonprofits', function(Blueprint $table)
		{
			//
		});
	}

}
