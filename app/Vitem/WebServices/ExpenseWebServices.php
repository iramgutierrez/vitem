<?php namespace Vitem\WebServices;

use Vitem\Repositories\ExpenseRepo;


class ExpenseWebServices extends BaseWebServices {

	/*public function getModel()
	{
		return new User;
	}*/

	static function all()
	{


		$return = ExpenseRepo::with(['user' , 'employee.user' , 'expense_type', 'store']);

		$usersPermitted = \ACLFilter::generateAuthCondition();

		if(count($usersPermitted))
		{
			$return = $return->whereIn('employee_id' , $usersPermitted);
		}

		$storesPermitted = \ACLFilter::generateStoreCondition();

		if(count($storesPermitted))
		{ 
			$return = $return->whereIn('store_id' , $storesPermitted);
		}

		$expenses = $return->get();

		return \Response::json($expenses);
		
	}
	static function findById()
	{
		$id = (isset($_GET['id'])) ? $_GET['id'] : false;

		if(!$id)
			return false;

		$expense = ExpenseRepo::with(['store']);
		
		$usersPermitted = \ACLFilter::generateAuthCondition();

		if(count($usersPermitted))
		{
			$expense = $expense->whereIn('employee_id' , $usersPermitted);
		}

		$storesPermitted = \ACLFilter::generateStoreCondition();

		if(count($storesPermitted))
		{ 
			$expense = $expense->whereIn('store_id' , $storesPermitted);
		}

		$expense = $expense->where('id' , $id)->first();

		return \Response::json($expense);

	}
	static function find()
	{

		$page = (!empty($_GET['page'])) ? $_GET['page'] : 1; 

		$perPage = (!empty($_GET['perPage'])) ? $_GET['perPage'] : 50;

		$find = (!empty($_GET['find'])) ? $_GET['find'] : '';

		$type = (!empty($_GET['type'])) ? $_GET['type'] : false;

		$expenses = [
		
			'data' => ExpenseRepo::findByPage($page , $perPage , $find , $type ),
			'total' => ExpenseRepo::countFind($find , $type )
		];

		return \Response::json($expenses);
	}

	static function getExpenses()
	{	

		$limit = (!empty($_GET['limit'])) ? $_GET['limit'] : 20;

		$expenses = ExpenseRepo::with(['user' , 'expense_type' , 'employee.user' ,'store']);
		
		$usersPermitted = \ACLFilter::generateAuthCondition();

		if(count($usersPermitted))
		{
			$expenses = $expenses->whereIn('employee_id' , $usersPermitted);
		}

		$storesPermitted = \ACLFilter::generateStoreCondition();

		if(count($storesPermitted))
		{ 
			$expenses = $expenses->whereIn('store_id' , $storesPermitted);
		}

		$expenses = $expenses->take($limit)
										->orderBy('id' , 'desc')
					  				  	->get();

		return \Response::json($expenses);
	}
}