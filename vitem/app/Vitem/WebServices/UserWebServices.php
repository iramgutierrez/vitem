<?php namespace Vitem\WebServices;

use Vitem\Repositories\UserRepo;


class UserWebServices extends BaseWebServices {

	/*public function getModel()
	{
		return new User;
	}*/

	static function all(){

		return \Response::json(\User::with('Employee')->with('Role')->get());
		
	}

	static function getByField()
	{

		$field = (isset($_GET['f'])) ? $_GET['f'] : false;

		$search = (isset($_GET['s'])) ? $_GET['s'] : false;

		if(!$field || !$search)
		{
			return false;
		}


		$users = UserRepo::getByField( $field , $search );

		return \Response::json($users);
	}

	static function getTopSellers()
	{
		$initDefault =time()- (7 * 24 * 60 * 60);

		$endDefault =  time() ;

		$typeDefault =  'total_sales' ;

		$limitDefault =  5;


		$init = (!empty($_GET['init'])) ? $_GET['init'] : $initDefault;

		$end = (!empty($_GET['end'])) ? $_GET['end'] : $endDefault;

		$type = (!empty($_GET['type'])) ? $_GET['type'] : $typeDefault;

		$limit = (!empty($_GET['limit'])) ? $_GET['limit'] : $limitDefault;

		$top = UserRepo::getTopSellers($init , $end , $type , $limit);

		return \Response::json($top);

	}

}