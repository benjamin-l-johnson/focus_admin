<?php

class VolunteerSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *         $table->increments('id');
     *      $table->string('name');
     *       $table->string('photo_path');
     *       $table->integer('rank');
     *       $table->timestamps();
	 * @return void
	 */
	public function run()
	{

        $content = 'Team member  Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent vel ligula scelerisque, vehicula dui eu, fermentum velit. Phasellus ac ornare eros, quis malesuada augue. Nunc ac nibh at mauris dapibus fermentum.';
        for( $i = 1 ; $i <= 6 ; $i++ )
        {

        	//Event is reserved in laravel
            DB::table('volunteers')->insert(     
    	            
        	array(
            'name' => "Volunteer $i",
            'email' =>"v$i@gmail.com",
            'photo_path'=>"images/1.jpg",
            'rank' => $i

            ));
        }
	}

}