<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class ClientsTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker::create();

		foreach(range(1, 40) as $index)
		{
			Client::create([
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
               	'image_profile' => str_replace('/var/www/html/vitem/public/images_profile_clients/', '', $faker->image('/var/www/html/vitem/public/images_profile_clients', 640, 480, 'people')),
				'client_type_id' => $faker->randomElement([1, 2, 3, 4]),
                'entry_date' => $faker->dateTimeThisYear('now'), 
				'status' => $faker->randomElement([0,1])

			]);
		}
	}

}