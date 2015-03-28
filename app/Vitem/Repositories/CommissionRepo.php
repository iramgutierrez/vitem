<?php namespace Vitem\Repositories;

class CommissionRepo extends BaseRepo {

	protected $CommissionRepo;	

	public function getModel()
	{
		return new Commission;
	}

	static function all(){

		$usersPermitted = \ACLFilter::generateAuthCondition();

		$return = \Commission::with(parent::with((['user', 'employee.user' , 'sale'])));

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

		$commissions = $return->get();

		return $commissions;
		
	}

	static function with($entities )
	{

		return \Commission::with(parent::with($entities));


	}

}