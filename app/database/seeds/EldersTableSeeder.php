<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;
use Sams\Entity\Elder;
use Sams\Entity\Instance;

class EldersTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker::create();

		foreach(range(1, 10) as $index)
		{
			$elder = Elder::create([
					'identity_card' => $faker->phoneNumber,
					'full_name'     => $faker->name,
					'address'       => $faker->address,
					'gender'        => 'm',
					'retired'       => 1,
					'pensioner'     => 1,
					'civil_status'  => 'married',
					'activiti'      => 1
			 ]);

			Instance::create([
				  'elder_id'    => $elder->id,
				  'referred'    => 'presidency_inass',
				  'address'     => $faker->address,
				  'visit_date'  => '2015-09-11',
				  'description' => $faker->word,
				  'state'       => 'confirmed'
				]);
		}
	}

}