<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class SalesTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker::create();		

		$admins = User::where('role_id' , 1)->lists('id');	

		$sellers = User::where('role_id' , 3)->lists('id');	

		$clients = Client::lists('id');

		foreach(range(1, 80) as $index)
		{
			$Sale = Sale::create([
				'sheet' => $faker->bothify('#######'),
               	'sale_date'     =>  $faker->dateTimeThisYear('now'),
				'sale_type' => $faker->randomElement(['contado' ,'apartado']),
				'pay_type' => $faker->randomElement(['efectivo' ,'cheque' , 'tarjeta']),
               	'liquidation_date' =>  $faker->dateTimeBetween('now','+1 year'),
                'user_id' => $faker->randomElement($admins),
                'employee_id' => $faker->randomElement($sellers),
                'client_id' => $faker->randomElement($clients),
                'store_id' => 1,
				'total' => $faker->randomFloat(2, '40000' ,'120000'),
			]);

			$products = [];

			for($p = 0; $p <= $faker->numberBetween(1, 8); $p++)
			{

				$products[$faker->numberBetween(1, 1376)]= [
					'quantity' => $faker->numberBetween(2, 6)
				];

			}

			$Sale->products()->sync($products);

			$packs = [];

			for($p = 0; $p <= $faker->numberBetween(1, 8); $p++)
			{

				$packs[$faker->numberBetween(1, 100)]= [
					'quantity' => $faker->numberBetween(2, 6)
				];

			}

			$Sale->packs()->sync($packs);


		}
	}

}