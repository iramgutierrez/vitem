<?php namespace Vitem\Repositories;

use Vitem\Repositories\PermissionRepo;

use Vitem\Filters\ACLFilter;

class ClientRepo extends BaseRepo {

	protected static $clients;

	protected $ClientRepo;	

	public function getModel()
	{
		return new \Client;
	}

	static function with($entities )
	{

		return \Client::with(parent::with($entities));


	}

	private static function generateLikeCondition( $sentence , $fields )
	{

		if($sentence != ''){

			self::$clients->where(
							function($query) use ($sentence , $fields) {
								
								foreach($fields as $field){

									$query->orWhere($field, 'LIKE' , '%' . $sentence . '%' );

								}

							}
							
						);

		}

	}

	public function search($find)
	{

		self::$clients = \Client::with('ClientType');

		self::generateLikeCondition( $find , ['id' , 'name' , 'email' ]);

		return self::$clients->get();

	}

}