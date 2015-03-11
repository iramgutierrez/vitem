<?php namespace Vitem\Repositories;

class DeliveryRepo extends BaseRepo {

	public function getModel()
	{
		return new Delivery;
	}

	static function all(){

		$usersPermitted = \ACLFilter::generateAuthCondition();

		$return = \Delivery::with(parent::with((['user', 'employee.user'])));

		if(count($usersPermitted))
		{
			$return->whereIn('employee_id' , $usersPermitted);
		}

		$deliveries = $return->get();

		return $deliveries;
		
	}

	static function with($entities )
	{

		return \Delivery::with(parent::with($entities));


	}

}