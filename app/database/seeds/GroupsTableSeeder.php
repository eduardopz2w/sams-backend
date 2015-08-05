<?php

// Composer: "fzaninotto/faker": "v1.3.0"
// use Faker\Factory as Faker;

class GroupsTableSeeder extends Seeder {

	public function run()
	{
			Sentry::createGroup([
					'name' => 'Admin',
					'permissions' => [
						'system.user'       => 1,
						'system.employee'   => 1,
						'system.audit'      => 1,
						'system.attendance' => 1,
						'system.permits'    => 1,
						'system.schedule'   => 1,
					]

			]);

			Sentry::createGroup([
					'name'        => 'User',
					'permissions' => [
					  'system.elder'      => 1,
					  'system.employee'   => 1,
					  'system.instance'   => 1,
					  'system.occurrence' => 1,
					  'system.attendance' => 1,
					  'system.permits'    => 1,
					  'system.schedule'   => 1,
					  'system.record'     => 1
					]
			]);

			Sentry::createGroup([
					'name' => 'SuperAdmin',
					'permissions' => [
					   'system' => 1
					]
			]);
	}

}