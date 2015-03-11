<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class ProductsTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker::create();

		$products = [
			'Base',
			'Buro',
			'Comoda',
			'Librero',
			'Centro de entretenimiento',
			'Sillón',
			'Mesa de centro',
			'Esquinero',
			'Lampara',
			'Silla',
			'Sofa',
			'Sofa-Cama',
			'Cantina',
			'Luna',
			'Organizador',
			'Cabecera'
		];

		$admins = User::where('role_id' , 1)->lists('id');

		$suppliers = Supplier::lists('id');

		foreach(range(1, 10000) as $index)
		{
			Product::create([
				'key' => $faker->bothify('??##???'),
               	'name'     => $faker->randomElement($products). ' ' . $faker->word,
				'stock' => rand(3,45),
				'model' => $faker->word,
				'description' => $faker->paragraph(3),
                'image' => str_replace('/var/www/html/vitem/public/images_products/', '', $faker->image('/var/www/html/vitem/public/images_products', 640, 480, 'technics')),
				'price' => $faker->randomFloat(2, '8000' ,'18000'),
                'cost'     => $faker->randomFloat(2, '1000' ,'8000'),
                'production_days'     => $faker->numberBetween(5, 45),
                'user_id' => $faker->randomElement($admins),
                'supplier_id' => $faker->randomElement($suppliers),
				'status' => 1
			]);
		}
	}

}