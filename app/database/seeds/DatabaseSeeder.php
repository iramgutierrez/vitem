<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

        $this->call('SalesTableSeeder');
        //$this->call('CandidateTableSeeder');
		// $this->call('UserTableSeeder');
	}

}
