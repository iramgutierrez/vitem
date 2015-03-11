<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class EmployeesTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker::create();

		foreach(range(1, 100) as $index)
		{
			$user = User::create([
               'username' => $faker->firstName,
               'email'     => $faker->email,
               'password'  => '123456',
               'name'     => $faker->firstName . ' ' . $faker->lastName,
               'street'     => $faker->streetName,
               'outer_number'     => $faker->buildingNumber,
               'inner_number'     => $faker->buildingNumber,
               'zip_code'     => $faker->postcode,
               'colony'     => $faker->city,
               'city'     => $faker->city,
               'state'     => $faker->state,
               'phone'     => $faker->phoneNumber,
               'image_profile' => str_replace('/var/www/html/vitem/public/images_profile/', '', $faker->image('/var/www/html/vitem/public/images_profile', 640, 480, 'people')),
               'role_id'      => $faker->randomElement([1, 2, 3, 4 , 5 , 6 , 7]),
               'status' => $faker->randomElement([0,1])
            ]);

			Employee::create([
                'id'          => $user->id,
                'salary' => $faker->randomFloat(2, '2000' ,'10000'),
                'entry_date' => $faker->dateTimeThisYear('now'), 
                'users_id'        => $user->id
			]);
		}
    
	}

}