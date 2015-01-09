<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class PacksTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker::create();		

		$admins = User::where('role_id' , 1)->lists('id');

		foreach(range(1, 100) as $index)
		{
			$Pack = Pack::create([
				'key' => $faker->bothify('??##???'),
               	'name'     =>  $faker->sentence(2),
				'description' => $faker->paragraph(3),
				'price' => $faker->randomFloat(2, '40000' ,'120000'),
                'cost'     => $faker->randomFloat(2, '5000' ,'30000'),
                'production_days'     => $faker->numberBetween(5, 45),
                'image' => str_replace('/var/www/html/vitem/public/images_packs/', '', $faker->image('/var/www/html/vitem/public/images_packs', 640, 480, 'technics')),				
                'user_id' => $faker->randomElement($admins),
				'status' => 1
			]);

			$products = [];

			for($p = 0; $p <= $faker->numberBetween(1, 8); $p++)
			{

				$products[$faker->numberBetween(1, 1376)]= [
					'quantity' => $faker->numberBetween(2, 6)
				];

			}

			$Pack->products()->sync($products);


		}
	}

}