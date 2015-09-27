<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;
use Sams\Entity\Citation;

class CitationsTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker::create();

		foreach(range(1, 29) as $index)
		{
			Citation::create([
        'elder_id' => $index,
        'state'    => 'loading',
        'date_day' => '2015-09-28',
        'hour'     => $faker->time,
        'reason'   => $faker->word
			]);
		}
	}

}