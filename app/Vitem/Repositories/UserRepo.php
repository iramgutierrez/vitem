<?php namespace Vitem\Repositories;

use Vitem\Repositories\PermissionRepo;

use Vitem\Filters\ACLFilter;

class UserRepo extends BaseRepo {

	protected $PermissionRepo;

	public function __construct()
	{

	}

	public function getModel()
	{
		return new User;
	}

	static function all(){

		$return = \User::with(parent::with(['Employee.commissions', 'Employee', 'Role']));

		$usersPermitted = ACLFilter::generateAuthCondition();

		if(count($usersPermitted))
		{
			$return->whereIn('id' , $usersPermitted);
		}

		$storesPermitted = ACLFilter::generateStoreCondition();

		if(count($storesPermitted))
		{
			$return->whereIn('store_id' , $storesPermitted);
		}

		$users = $return->get();

		return $users;
		
	}

	static function getByField( $field , $search)
	{

		$usersPermitted = ACLFilter::generateAuthCondition();

		$return = \User::with(parent::with(['Employee.commissions', 'Employee.user', 'Role']));

		if(count($usersPermitted))
		{
			$return->whereIn('id' , $usersPermitted);
		}

		$storesPermitted = ACLFilter::generateStoreCondition();

		if(count($storesPermitted))
		{
			$return->whereIn('store_id' , $storesPermitted);
		}

		$users = $return->where($field , $search)->get();

		return $users;
	}

	static function getTopSellers($init , $end , $type = 'total_sales' , $limit = 5)
	{ 
		$initDate = date('Y-m-d' , $init);

		$endDate = date('Y-m-d' , $end);

		$usersPermitted = ACLFilter::generateAuthCondition();

		$return =  \Sale::with(parent::with(['employee.user']));

		if(count($usersPermitted))
		{
			$return->whereIn('employee_id' , $usersPermitted);
		}

		$storesPermitted = ACLFilter::generateStoreCondition();

		if(count($storesPermitted))
		{
			$return->whereIn('store_id' , $storesPermitted);
		}
		
		$sales = $return
						->where('sale_date' , '>=' , $initDate)
						->where('sale_date' , '<=' , $endDate)
						->groupBy('employee_id')
						->orderBy($type  , 'desc')
						->take(5)
						->select([
							\DB::raw('count(*) as total_sales') , 
							\DB::raw('sum(total) as total') , 
							'employee_id'
						])
						->get();

		return $sales;

		//exit();


	}

	static function with($entities )
	{

		return \User::with(parent::with($entities));


	}

}