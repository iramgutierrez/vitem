<?php namespace Vitem\Repositories;

class DevolutionRepo extends BaseRepo {

	/*public function getModel()
	{
		return new Store;
	}*/

	protected static $devolutions;

	public function getModel()
    {
        return new Devolution;
    }

	static function all(){

		return \Devolution::all();

	}

	static function findByPage($page , $perPage , $find , $operatorOrderDate , $orderDate , $supplier_id = false)
	{

		$offset = ($page - 1 ) * $perPage;

		self::$devolutions = \Devolution::with([
										'products',
										'user',
										'supplier'
									]);

		self::generateLikeCondition( $find , ['id']);

		self::generateSupplierIdCondition( $supplier_id);

		self::generateOrderDateCondition( $operatorOrderDate , $orderDate);

		$whereUserId = \ACLFilter::generateAuthCondition();

		if(count($whereUserId))
			self::$devolutions->whereIn( 'user_id' , $whereUserId);

		self::paginate($offset , $perPage);

		$whereUserId = \ACLFilter::generateAuthCondition();

		if(count($whereUserId))
			self::$devolutions->whereIn( 'user_id' , $whereUserId);

		return self::$devolutions->get();

	}

	static function countFind($find , $operatorOrderDate , $orderDate , $supplier_id = false)
	{

		self::$devolutions = \Devolution::with([
										'products',
										'user',
										'supplier'
									]);

		self::generateLikeCondition( $find , ['id']);

		self::generateSupplierIdCondition( $supplier_id);

		self::generateOrderDateCondition( $operatorOrderDate , $orderDate);

		$whereUserId = \ACLFilter::generateAuthCondition();

		if(count($whereUserId))
			self::$devolutions->whereIn( 'user_id' , $whereUserId);

		return self::$devolutions->count();

	}



	private static function generateLikeCondition( $sentence , $fields )
	{

		if($sentence != ''){

			self::$devolutions->where(
							function($query) use ($sentence , $fields) {

								foreach($fields as $field){

									$query->orWhere($field, 'LIKE' , '%' . $sentence . '%' );

								}

							}

						);

		}

	}

	private static function generateSupplierIdCondition( $supplier_id )
	{

		if( $supplier_id != '' ){

			self::$devolutions->where( 'supplier_id', '=' ,$supplier_id );

		}

	}

	private static function generateOrderDateCondition( $operatorOrderDate , $orderDate )
	{

		if( $operatorOrderDate && $orderDate){

			self::$devolutions->where( 'order_date', $operatorOrderDate ,$orderDate );

		}

	}

	private static function paginate( $offset , $perPage )
	{

		self::$devolutions->skip($offset)
					   ->take($perPage);

	}

	static function getProducts($devolutionId)
	{
		$devolution = \Devolution::with(['products.supplier'])->where('id' , $devolutionId)->first();

		if(!$devolution)
			return false;

		return $devolution->products;
	}

	static function with($entities )
	{

		return \Devolution::with(parent::with($entities));


	}

}