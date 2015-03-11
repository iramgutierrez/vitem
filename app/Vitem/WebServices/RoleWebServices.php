<?php namespace Vitem\WebServices;

//use Vitem\Repositories\RoleRepo;


class RoleWebServices extends BaseWebServices {

	/*public function getModel()
	{
		return new User;
	}*/

	static function all(){

		return \Response::json(\Role::with('Permission')->get());
		
	}	

	static function getById()
	{

		$id = (isset($_GET['id'])) ? $_GET['id'] : false;

		if(!$id)
		{
			return false;
		}


		$role = \Role::with('Permission' , 'User.Employee')->find($id);

		return \Response::json($role);
	}

}