<?php

class RelateSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
        
        for($i=1;$i<5;$i++)
        {
            $stu = Student::find($i+2);
            $vent = Vent::find($i);
            $vent->students()->attach($stu->id);
            $vent->volunteers()->attach($i);
            $vent->volunteers()->attach($i+2);
            $vent->save();

        }
	}

}