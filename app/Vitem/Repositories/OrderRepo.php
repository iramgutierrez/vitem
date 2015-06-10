<?php namespace Vitem\Repositories;

class OrderRepo extends BaseRepo {

	/*public function getModel()
	{
		return new Store;
	}*/

	protected static $orders;

	public function getModel()
    {
        return new Order;
    }

	static function all(){

		return \Order::all();
		
	}	

	static function findByPage($page , $perPage , $find , $operatorOrderDate , $orderDate , $supplier_id = false)
	{		

		$offset = ($page - 1 ) * $perPage;

		self::$orders = \Order::with([
										'products',
										'user',
										'supplier' 
									]);

		self::generateLikeCondition( $find , ['id']);

		self::generateSupplierIdCondition( $supplier_id);

		self::generateOrderDateCondition( $operatorOrderDate , $orderDate);

		$whereUserId = \ACLFilter::generateAuthCondition();

		if(count($whereUserId))
			self::$orders->whereIn( 'user_id' , $whereUserId);

		self::paginate($offset , $perPage);

		$whereUserId = \ACLFilter::generateAuthCondition();

		if(count($whereUserId))
			self::$orders->whereIn( 'user_id' , $whereUserId);

		return self::$orders->get();

	}

	static function countFind($find , $operatorOrderDate , $orderDate , $supplier_id = false)
	{				
		
		self::$orders = \Order::with([
										'products',
										'user',
										'supplier' 
									]);

		self::generateLikeCondition( $find , ['id']);

		self::generateSupplierIdCondition( $supplier_id);

		self::generateOrderDateCondition( $operatorOrderDate , $orderDate);

		$whereUserId = \ACLFilter::generateAuthCondition();

		if(count($whereUserId))
			self::$orders->whereIn( 'user_id' , $whereUserId);

		return self::$orders->count();		

	}



	private static function generateLikeCondition( $sentence , $fields )
	{

		if($sentence != ''){

			self::$sales->where(
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
		
			self::$orders->where( 'supplier_id', '=' ,$supplier_id );

		}

	}

	private static function generateOrderDateCondition( $operatorOrderDate , $orderDate )
	{

		if( $operatorOrderDate && $orderDate){
		
			self::$orders->where( 'order_date', $operatorOrderDate ,$orderDate );

		}

	}

	private static function paginate( $offset , $perPage )
	{

		self::$orders->skip($offset)
					   ->take($perPage);

	}

	static function getProducts($orderId)
	{
		$order = \Order::with(['products.supplier'])->where('id' , $orderId)->first();

		if(!$order)
			return false;

		return $order->products;
	}

	static function with($entities )
	{

		return \Order::with(parent::with($entities));


	}

}