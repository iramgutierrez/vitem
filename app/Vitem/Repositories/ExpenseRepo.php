<?php namespace Vitem\Repositories;

class ExpenseRepo extends BaseRepo {

	/*public function getModel()
	{
		return new Store;
	}*/

	protected static $expenses;

	public function getModel()
    {
        return new Expense;
    }

	static function all(){

		$return = \Expense::with(parent::with(['user' , 'employee.user' , 'expense_type']));

		$usersPermitted = \ACLFilter::generateAuthCondition();

		if(count($usersPermitted))
		{
			$return = $return->whereIn('employee_id' , $usersPermitted);
		}

		$expenses = $return->get();

		return $expenses;

	}	

	static function findByPage($page , $perPage , $find , $type )
	{		
		
		$offset = ($page - 1 ) * $perPage;

		self::$expenses = \Expense::with(parent::with(['user' , 'employee.user' , 'expense_type']));

		$usersPermitted = \ACLFilter::generateAuthCondition();

		if(count($usersPermitted))
		{
			self::$expenses = self::$expenses->whereIn('employee_id' , $usersPermitted);
		}
		
		self::generateLikeCondition( $find , ['id' , 'employee.user.name' , 'concept' , 'description']);

		self::generateTypeCondition( $type);

		self::paginate($offset , $perPage);

		return self::$expenses->get();		

	}

	static function countFind($find , $type )
	{	

		self::$expenses = \Expense::with(parent::with(['user' , 'employee.user' , 'expense_type']));

		$usersPermitted = \ACLFilter::generateAuthCondition();

		if(count($usersPermitted))
		{
			self::$expenses = self::$expenses->whereIn('employee_id' , $usersPermitted);
		}

		self::generateLikeCondition( $find , ['id' , 'employee.user.name' , 'concept' , 'description']);

		self::generateTypeCondition( $type);

		return self::$expenses->count();		

	}

	private static function generateLikeCondition( $sentence , $fields )
	{

		if($sentence != ''){

			self::$expenses->where(
							function($query) use ($sentence , $fields) {
								
								foreach($fields as $field){

									$query->orWhere($field, 'LIKE' , '%' . $sentence . '%' );

								}

							}
							
						);

		}

	}

	private static function generateTypeCondition( $type )
	{

		if( $type != '' ){
		
			self::$expenses->where( 'expense_type_id', '=' ,$type );

		}

	}

	private static function paginate( $offset , $perPage )
	{

		self::$expenses->skip($offset)
					   ->take($perPage);

	}

	static function with($entities )
	{

		return \Expense::with(parent::with($entities));


	}

}