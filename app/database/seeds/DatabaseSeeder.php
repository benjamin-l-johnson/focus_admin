<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		$this->call('EventSeeder');
		//$this->call('NonprofitSeeder');
		//$this->call('StudentSeeder');

		$this->call('VolunteerSeeder');
		$this->call('RoleSeeder');
		$this->call('MemberSeeder');
		//$this->call('RelateSeeder'); 
	}

}
