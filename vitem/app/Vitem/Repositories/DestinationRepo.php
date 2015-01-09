<?php namespace Vitem\Repositories;

class DestinationRepo extends BaseRepo {

	/*public function getModel()
	{
		return new Store;
	}*/

	protected static $destinations;

	public function getModel()
    {
        return new Destination;
    }

	static function all(){

		return \Destination::all();
		
	}	

	static function findByPage($page , $perPage , $find , $type )
	{		
		
		$offset = ($page - 1 ) * $perPage;

		self::$destinations = \Destination::with('user');
		
		self::generateLikeCondition( $find , ['id' , 'zip_code' , 'colony' , 'town' , 'state']);

		self::generateTypeCondition( $type);

		self::paginate($offset , $perPage);

		return self::$destinations->get();		

	}

	static function countFind($find , $type )
	{				
		

		self::$destinations = \Destination::with('user');

		self::generateLikeCondition( $find , ['id' , 'zip_code' , 'colony' , 'town' , 'state']);

		self::generateTypeCondition( $type);

		return self::$destinations->count();		

	}

	private static function generateLikeCondition( $sentence , $fields )
	{

		if($sentence != ''){

			self::$destinations->where(
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
		
			self::$destinations->where( 'type', '=' ,$type );

		}

	}

	private static function paginate( $offset , $perPage )
	{

		self::$destinations->skip($offset)
					   ->take($perPage);

	}

}