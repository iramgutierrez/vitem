<?php namespace Vitem\WebServices;

use Vitem\Repositories\ExpenseRepo;


class ExpenseWebServices extends BaseWebServices {

	/*public function getModel()
	{
		return new User;
	}*/

	static function all()
	{

		return \Response::json(ExpenseRepo::all());
								/*with('user' , 'employee.user' , 'expense_type')
								->get());*/
		
	}
	static function findById()
	{
		$id = (isset($_GET['id'])) ? $_GET['id'] : false;

		if(!$id)
			return false;


		$destination = \Expense::with()
						 ->where('id' , $id)->first();

		return \Response::json($destination);

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

		return \Response::json(\Expense::with(['user' , 'expense_type' , 'employee.user'])
										->take($limit)
										->orderBy('id' , 'desc')
					  				  	->get());
	}
}