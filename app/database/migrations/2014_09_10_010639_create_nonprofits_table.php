<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNonprofitsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('nonprofits', function(Blueprint $table)
		{
			$table->increments('id');
            $table->string('name');
            $table->string('read_more');
            $table->text('content');
            $table->string('cover_photo_name');
            $table->string('images_path');
			$table->integer('vent_id');
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
		Schema::drop('nonprofits');
	}

}
