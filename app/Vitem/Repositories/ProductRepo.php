<?php namespace Vitem\Repositories;


class ProductRepo extends BaseRepo {

	public function getModel()
	{
		return new Product;
	}

	protected static $products;


	static function all(){

		return \Product::all();
		
	}

	static function getByField( $field , $search)
	{
		$users = \Product::where($field , $search)->get();

		return $users;
	}

	static function findByPage($page , $perPage , $find , $status ,$supplier_id = false)
	{		
		
		$offset = ($page - 1 ) * $perPage;

		self::$products = self::with(['Sales.client' , 'Sales.Employee.User' , 'Supplier' ]);

		self::generateStatusCondition( $status);

		self::generateSupplierIdCondition( $supplier_id);
		
		self::generateLikeCondition( $find , ['id' , 'name' , 'key' , 'model']);

		self::paginate($offset , $perPage);

		return self::$products->get();		

	}

	static function countFind($find , $status,$supplier_id = false)
	{				
		
		self::$products = self::with(['Sales.client' , 'Sales.Employee.User' , 'Supplier' ]);

		self::generateStatusCondition( $status);

		self::generateSupplierIdCondition( $supplier_id);

		self::generateLikeCondition( $find , ['id' , 'name' , 'key' , 'model']);

		return self::$products->count();		

	}

	private static function generateStatusCondition( $status )
	{

		if( $status != '' ){
		
			self::$products->where( 'status', '=' ,$status );

		}

	}

	private static function generateSupplierIdCondition( $supplier_id )
	{

		if( $supplier_id ){
		
			self::$products->where( 'supplier_id', '=' ,$supplier_id );

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



	static function with($entities )
	{

		return \Product::with(parent::with($entities));


	}

}