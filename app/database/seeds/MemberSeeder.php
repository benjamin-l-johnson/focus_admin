<?php

class MemberSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
        //DB::table('events')->delete();
        $content = 'Team member  Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent vel ligula scelerisque, vehicula dui eu, fermentum velit. Phasellus ac ornare eros, quis malesuada augue. Nunc ac nibh at mauris dapibus fermentum.';
        //for( $i = 1 ; $i <= 4 ; $i++ )
        //{

            //Event is reserved in laravel
            Member::create(    
                    
            array(
            'name' => "Ben",
            'job_title' => "King of the castle",
            'about' => $content,
            'photo_path'=>"images/1.jpg",
            "linkedin" => 'https://www.linkedin.com/',
            "facebook" => 'https://www.facebook.com/',
            "twitter" => 'https://twitter.com/',
            "email"   => "ben@benjamin-l-johnson.me",
            "password" => Hash::make('ExAmple9000199')
            ))->makeAdmin('admin');

            Member::create(     
                    
            array(
            'name' => "Ben",
            'job_title' => "King of the castle",
            'about' => $content,
            'photo_path'=>"images/1.jpg",
            "linkedin" => 'https://www.linkedin.com/',
            "facebook" => 'https://www.facebook.com/',
            "twitter" => 'https://twitter.com/',
            "email"   => "ben@ben.com",
            "password" => Hash::make('12345678')
            ))->makeAdmin('admin');
        //}
	}

}