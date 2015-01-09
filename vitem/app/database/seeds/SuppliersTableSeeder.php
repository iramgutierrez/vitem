<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class SuppliersTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker::create();

		foreach(range(1, 40) as $index)
		{
			Supplier::create([
				'name' => $faker->firstName . ' ' . $faker->lastName,
               	'email'     => $faker->email,
				'phone' => $faker->phoneNumber,
				'email' => $faker->email,
				'business_name' => $faker->company,
				'rfc' => $faker->word,
                'street'     => $faker->streetName,
                'outer_number'     => $faker->buildingNumber,
                'inner_number'     => $faker->buildingNumber,
                'zip_code'     => $faker->postcode,
                'colony'     => $faker->city,
                'city'     => $faker->city,
               	'state'     => $faker->state,
				'status' => $faker->randomElement([0,1])

			]);
		}
	}

}