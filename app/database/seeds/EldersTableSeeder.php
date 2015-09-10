<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;
use Sams\Entity\Elder;
use Sams\Entity\Instance;

class EldersTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker::create();

		foreach(range(1, 60) as $index)
		{
			$elder = Elder::create([
					'identity_card' => $faker->phoneNumber,
					'full_name'     => $faker->name,
					'address'       => $faker->address,
					'activiti'      => 0
			 ]);

			Instance::create([
				  'elder_id'    => $elder->id,
				  'referred'    => 'presidency_inass',
				  'address'     => $faker->address,
				  'visit_date'  => '2015-09-11',
				  'description' => $faker->word,
				  'state'       => 'waiting'
				]);
		}
	}

}