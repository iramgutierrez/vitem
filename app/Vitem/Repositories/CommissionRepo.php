<?php namespace Vitem\Repositories;

class CommissionRepo extends BaseRepo {

	protected $CommissionRepo;	

	public function getModel()
	{
		return new Commission;
	}

	static function all(){

		$usersPermitted = \ACLFilter::generateAuthCondition();

		$return = \Commission::with(parent::with((['user', 'employee.user'])));

		if(count($usersPermitted))
		{
			$return->whereIn('employee_id' , $usersPermitted);
		}

		$commissions = $return->get();

		return $commissions;
		
	}

	static function with($entities )
	{

		return \Commission::with(parent::with($entities));


	}

}