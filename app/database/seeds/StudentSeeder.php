<?php

class StudentSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
        //DB::table('events')->delete();
		$content = 'Student Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent vel ligula scelerisque, vehicula dui eu, fermentum velit. Phasellus ac ornare eros, quis malesuada augue. Nunc ac nibh at mauris dapibus fermentum. 
           	In in aliquet nisi, ut scelerisque arcu. Integer tempor, nunc ac lacinia cursus, mauris justo volutpat elit, eget accumsan nulla nisi ut nisi. Etiam non convallis ligula. Nulla urna augue,dignissim ac semper in, ornare ac mauris. Duis nec felis mauris.';
        for( $i = 1 ; $i <= 6 ; $i++ )
        {
        	
            DB::table('students')->insert(     
    	            
        	array(
            'name' => "Students $i",
            'read_more' => substr($i.$content, 0, 120),
            'content' => $i.$content,
            'images_path'=>"images/stu$i/",
            'cover_photo_name'=>'cover.jpg',
            ));
        }
	}

}