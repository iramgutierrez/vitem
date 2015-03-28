<?php namespace Vitem\Repositories;

class DeliveryRepo extends BaseRepo {

	protected static $deliveries;

	public function getModel()
	{
		return new Delivery;
	}

	static function all(){

		$usersPermitted = \ACLFilter::generateAuthCondition();

		$return = \Delivery::with(parent::with((['user', 'employee.user', 'sale' , 'destination' ])));

		if(count($usersPermitted))
		{
			$return->whereIn('employee_id' , $usersPermitted);
		}			

        $whereStoreId = \ACLFilter::generateStoreCondition();

        $return->whereIn('sale_id' , function($query) use ($whereStoreId) {

								$query->select(\DB::raw('id'))
									  ->from('sales')
									  ->whereIn('store_id' , $whereStoreId);

							});

		$deliveries = $return->get();

		return $deliveries;
		
	}

	static function findByPage($page , $perPage , $find )
	{		
		
		$offset = ($page - 1 ) * $perPage;

		self::$deliveries = \Delivery::with('user' , 'destination' , 'employee.user' , 'sale');
		
		self::generateLikeCondition( $find , ['id' ]);

		self::paginate($offset , $perPage);

		return self::$deliveries->get();		

	}

	static function countFind($find )
	{				
		

		self::$deliveries = \Delivery::with('user' , 'destination' , 'employee.user' , 'sale');

		self::generateLikeCondition( $find , ['id' ]);

		return self::$deliveries->count();		

	}

	private static function generateLikeCondition( $sentence , $fields )
	{

		if($sentence != ''){

			self::$deliveries->where(
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

		self::$deliveries->skip($offset)
					   ->take($perPage);

	}

	static function with($entities )
	{

		return \Delivery::with(parent::with($entities));


	}

}