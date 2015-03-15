<?php namespace Vitem\Repositories;

class StoreRepo extends BaseRepo {

	/*public function getModel()
	{
		return new Store;
	}*/

	protected static $stores;

	public function getModel()
    {
        return new Store;
    }

	static function all(){

		return \Store::all();
		
	}	

	static function findByPage($page , $perPage , $find )
	{		

		$offset = ($page - 1 ) * $perPage;

		self::$stores = \Store::with([
										
										'user',
									]);

		self::generateLikeCondition( $find , ['id', 'name' , 'email' , 'address' , 'phone']);

		self::paginate($offset , $perPage);

		return self::$stores->get();

	}

	static function countFind($find)
	{				
		
		self::$stores = \Store::with([
										'user'
									]);

		self::generateLikeCondition( $find , ['id', 'name' , 'email' , 'address' , 'phone']);

		return self::$stores->count();		

	}



	private static function generateLikeCondition( $sentence , $fields )
	{

		if($sentence != ''){

			self::$stores->where(
							function($query) use ($sentence , $fields) {
								
								foreach($fields as $field){

									$query->orWhere($field, 'LIKE' , '%' . $sentence . '%' );

								}

							}
							
						);

		}

	}

	private static function paginate( $offset , $perPage )
	{

		self::$stores->skip($offset)
					   ->take($perPage);

	}

	static function with($entities )
	{

		return \Store::with(parent::with($entities));


	}

}