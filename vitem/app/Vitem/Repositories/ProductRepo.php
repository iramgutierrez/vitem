<?php namespace Vitem\Repositories;


class ProductRepo extends BaseRepo {

	/*public function getModel()
	{
		return new User;
	}*/

	protected static $products;


	static function all(){

		return \Product::all();
		
	}

	static function getByField( $field , $search)
	{
		$users = \Product::where($field , $search)->get();

		return $users;
	}

	static function findByPage($page , $perPage , $find , $status)
	{		
		
		$offset = ($page - 1 ) * $perPage;

		self::$products = \Product::with(['Supplier' ,'User']);

		self::generateStatusCondition( $status);
		
		self::generateLikeCondition( $find , ['id' , 'name' , 'key' , 'model']);

		self::paginate($offset , $perPage);

		return self::$products->get();		

	}

	static function countFind($find , $status)
	{				
		
		self::$products = \Product::with(['Supplier' ,'User']);

		self::generateStatusCondition( $status);

		self::generateLikeCondition( $find , ['id' , 'name' , 'key' , 'model']);

		return self::$products->count();		

	}

	private static function generateStatusCondition( $status )
	{

		if( $status != '' ){
		
			self::$products->where( 'status', '=' ,$status );

		}

	}

	private static function generateLikeCondition( $sentence , $fields )
	{

		if($sentence != ''){

			self::$products->where(
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

		self::$products->skip($offset)
					   ->take($perPage);

	}

}