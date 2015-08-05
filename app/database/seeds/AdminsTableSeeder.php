<?php

// Composer: "fzaninotto/faker": "v1.3.0"

class AdminsTableSeeder extends Seeder {

	public function run()
	{
			$group = Sentry::findGroupByName('SuperAdmin');

			$user = Sentry::createUser(
				[
						'email'      => 'sams@gmail.com',
						'password'   => 123456,
						'first_name' => 'admin',
						'last_name'  => 'user',
						'activated'  => 1
				]);

			$user->addGroup($group);
	}

}