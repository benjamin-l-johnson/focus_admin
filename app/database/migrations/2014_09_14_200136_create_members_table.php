<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMembersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('members', function(Blueprint $table)
		{
			$table->increments('id');
            $table->string('name');
            $table->string('job_title');
            $table->string('email', 100)->unique();
    		$table->string('password', 64);
            $table->string('remember_token', 100)->nullable();

            $table->text('about');
            $table->text('linkedin');
            $table->text('facebook');
            $table->text('twitter');
            $table->string('photo_path');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('members');
	}

}
