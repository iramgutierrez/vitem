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

		return \Expense::all();
		
	}	

	static function findByPage($page , $perPage , $find , $type )
	{		
		
		$offset = ($page - 1 ) * $perPage;

		self::$expenses = \Expense::with('user' , 'employee.user' , 'expense_type');
		
		self::generateLikeCondition( $find , ['id' , 'employee.user.name' , 'concept' , 'description']);

		self::generateTypeCondition( $type);

		self::paginate($offset , $perPage);

		return self::$expenses->get();		

	}

	static function countFind($find , $type )
	{				
		

		self::$expenses = \Destination::with('user' , 'employee.user' , 'expense_type');
		

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

}