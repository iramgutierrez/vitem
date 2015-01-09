<?php namespace Vitem\Repositories;


class UserRepo extends BaseRepo {

	/*public function getModel()
	{
		return new User;
	}*/

	static function all(){

		return \User::all();
		
	}

	static function getByField( $field , $search)
	{
		$users = \User::with(['Employee' , 'Employee.user', 'Role' ])->where($field , $search)->get();

		return $users;
	}

	static function getTopSellers($init , $end , $type = 'total_sales' , $limit = 5)
	{ 
		$initDate = date('Y-m-d' , $init);

		$endDate = date('Y-m-d' , $end);
		
		$sales = \Sale::with(['employee.user'])
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

}