<?php namespace Vitem\WebServices;

use Vitem\Repositories\DestinationRepo;


class DestinationWebServices extends BaseWebServices {

	/*public function getModel()
	{
		return new User;
	}*/

	static function all()
	{

		return \Response::json(\Destination::get());
		
	}
	static function findById()
	{
		$id = (isset($_GET['id'])) ? $_GET['id'] : false;

		if(!$id)
			return false;


		$destination = \Destination::with()
						 ->where('id' , $id)->first();

		return \Response::json($destination);

	}
	static function find()
	{

		$page = (!empty($_GET['page'])) ? $_GET['page'] : 1; 

		$perPage = (!empty($_GET['perPage'])) ? $_GET['perPage'] : 50;

		$find = (!empty($_GET['find'])) ? $_GET['find'] : '';

		$type = (!empty($_GET['type'])) ? $_GET['type'] : false;

		$destinations = [
		
			'data' => DestinationRepo::findByPage($page , $perPage , $find , $type ),
			'total' => DestinationRepo::countFind($find , $type )
		];

		return \Response::json($destinations);
	}
}