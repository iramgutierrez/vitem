<?php namespace Vitem\WebServices;

use Vitem\Repositories\PermissionRepo;


class PermissionWebServices extends BaseWebServices {

	/*public function getModel()
	{
		return new User;
	}*/

	static function all(){

		return \Response::json(\Permission::get());
		
	}

	static function checkBySlug()
	{

		$entity_slug = (!empty($_GET['entity_slug'])) ? $_GET['entity_slug'] : false;

		$action_slug = (!empty($_GET['action_slug'])) ? $_GET['action_slug'] : false;

		$role_slug = (!empty($_GET['role_slug'])) ? $_GET['role_slug'] : false;

		echo PermissionRepo::checkBySlug($entity_slug , $action_slug , $role_slug);


	}

	static function getByRoleId()
	{

		$role_id = (!empty($_GET['role_id'])) ? $_GET['role_id'] : false;

		if($role_id)
			return \Response::json(\Permission::with('Role' , 'Action' , 'Entity')->where('role_id' , $role_id)->get());




	}

}