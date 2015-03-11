<?php namespace Vitem\WebServices;

//use Vitem\Repositories\RoleRepo;


class ActionWebServices extends BaseWebServices {

	/*public function getModel()
	{
		return new User;
	}*/

	static function all(){

		return \Response::json(\Action::get());
		
	}	

}