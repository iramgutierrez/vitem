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

		$return = \User::with(parent::with(['Employee.commissions', 'Employee', 'Role' , 'Store']));

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

		$return = \User::with(parent::with(['Employee.commissions', 'Employee.user', 'Role' , 'Store']));

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

		$return =  \Sale::with(parent::with(['employee.user.store']));

		if(count($usersPermitted))
		{
			$return->whereIn('employee_id' , $usersPermitted);
		}

		$storesPermitted = ACLFilter::generateStoreCondition(); 	

		if(count($storesPermitted))
		{
			$return->whereIn('employee_id', function ($query) use ($storesPermitted) {

				$query->select(\DB::raw('id'))
						->from('users')
						->whereIn('users.store_id' , $storesPermitted);

			});

			//$return->whereIn('employee_id' , function());
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

	static function compareSellers($seller_id_1 , $seller_id_2 , $init_date , $end_date)
	{

		$seller_1 =  \Employee::with(parent::with(['user' , 'user.store' , 'sales' , 'commissions' , 'expenses' , 'sale_payments']));

		$seller_2 =  \Employee::with(parent::with(['user' , 'user.store' , 'sales' , 'commissions' , 'expenses' , 'sale_payments']));

		$usersPermitted = ACLFilter::generateAuthCondition(); 

		$storesPermitted = ACLFilter::generateStoreCondition();

		if(count($usersPermitted))
		{
			$seller_1->whereIn('id' , $usersPermitted);

			$seller_2->whereIn('id' , $usersPermitted);
		} 	

		if(count($storesPermitted))
		{
			$seller_1->whereIn('id', function ($query) use ($storesPermitted) {

				$query->select(\DB::raw('id'))
						->from('users')
						->whereIn('users.store_id' , $storesPermitted);

			});

			$seller_2->whereIn('id', function ($query) use ($storesPermitted) {

				$query->select(\DB::raw('id'))
						->from('users')
						->whereIn('users.store_id' , $storesPermitted);

			});
		}

		$seller_1 = $seller_1->where('id', $seller_id_1)->first();

		$seller_2 = $seller_2->where('id', $seller_id_2)->first();

		if(!$seller_1 || !$seller_2)
		{
			return [];
		}

		$compare = [

			$seller_id_1 = $seller_1,

			$seller_id_2 = $seller_2
		];

		return $compare;

	}

	static function compareDrivers($driver_id_1 , $driver_id_2 , $init_date , $end_date)
	{

		$driver_1 =  \Employee::with(parent::with(['user' , 'user.store' , 'deliveries' , 'commissions' , 'expenses' ]));

		$driver_2 =  \Employee::with(parent::with(['user' , 'user.store' , 'deliveries' , 'commissions' , 'expenses' ]));

		$usersPermitted = ACLFilter::generateAuthCondition(); 

		$storesPermitted = ACLFilter::generateStoreCondition();

		if(count($usersPermitted))
		{
			$driver_1->whereIn('id' , $usersPermitted);

			$driver_2->whereIn('id' , $usersPermitted);
		} 	

		if(count($storesPermitted))
		{
			$driver_1->whereIn('id', function ($query) use ($storesPermitted) {

				$query->select(\DB::raw('id'))
						->from('users')
						->whereIn('users.store_id' , $storesPermitted);

			});

			$driver_2->whereIn('id', function ($query) use ($storesPermitted) {

				$query->select(\DB::raw('id'))
						->from('users')
						->whereIn('users.store_id' , $storesPermitted);

			});
		}

		$driver_1 = $driver_1->where('id', $driver_id_1)->first();

		$driver_2 = $driver_2->where('id', $driver_id_2)->first();

		if(!$driver_1 || !$driver_2)
		{
			return [];
		}

		$compare = [

			$driver_id_1 = $driver_1,

			$driver_id_2 = $driver_2
		];

		return $compare;

	}

}