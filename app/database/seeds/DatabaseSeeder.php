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

		// $this->call('UserTableSeeder');
		$this->call('ConfigurationsTableSeeder');
		$this->call('GroupsTableSeeder');
		$this->call('AdminsTableSeeder');
		$this->call('AccountsTableSeeder');
		// $this->call('CitationsTableSeeder');
		// $this->call('EldersTableSeeder');
	}

}
