<?php

class RoleSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
        
        $role_data = array(
            array('name' => "delete_members")
        );
        
        foreach ($role_data AS $role) {
            Role::create($role);
        }
	}

}