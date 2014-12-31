<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{

		Schema::create('vents', function(Blueprint $table) {
            
            $table->increments('id');
            $table->string('title');
            $table->string('read_more');
            $table->text('content');
            $table->string('images_path');
            $table->string('cover_photo_name');
            $table->integer('student_id');
            $table->integer('nonprofit_id');
            $table->integer('volunteer_id');
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
		//
		Schema::drop('vents');
	}

}
