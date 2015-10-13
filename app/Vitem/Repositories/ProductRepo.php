<?php namespace Vitem\Repositories;


class ProductRepo extends BaseRepo {

	public function getModel()
	{
		return new \Product;
	}

	protected static $products;

	public function search($find )
	{

		self::$products = \Product::with('colors');

		self::generateLikeCondition( $find , ['id' , 'name' , 'key' , 'model']);

		/*self::$products->whereIn('id', function ($query) use ($store_id) {

				$query->select(\DB::raw('product_id'))
						->from('product_store')
						->where('store_id' , $store_id)
						->where('product_store.quantity' , '>' , 0);

			});*/

		return self::$products->get();

	}


	static function all(){

		return \Product::all();

	}

	static function getByField( $field , $search)
	{
		$products = \Product::where($field , $search)->get();

		return $products;
	}

	static function getByKey( $key )
	{
		$products = \Product::with('colors')->where('key' , $key);

		/*$products = $products->whereIn('id', function ($query) use ($store_id) {

				$query->select(\DB::raw('product_id'))
						->from('product_store')
						->where('store_id' , $store_id)
						->where('product_store.quantity' , '>' , 0);

			});*/

		$products = $products->first();

		return $products;
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