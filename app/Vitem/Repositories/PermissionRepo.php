<?php namespace Vitem\Repositories;

use Illuminate\Database\Eloquent\ModelNotFoundException;

class PermissionRepo extends BaseRepo {

	public function getModel()
	{
		
	}

	public function check( $entity , $action , $role_id ){

		$entity_id = \Entity::whereName( $entity )->pluck('id');

		$action_id = \Action::whereName( $action )->pluck('id');

		try
		{
			$permission = \Permission::
						where("entity_id" , $entity_id )
						->where("action_id" , $action_id )
						->where("role_id" , $role_id )
						->firstOrFail();

		}catch(ModelNotFoundException $e)
		{

		    return false;

		}
		

		return true;
		
	}

	static function checkAuth( $entity , $action ){
        //dd($action);
		$entity_id = \Entity::whereName( $entity )->pluck('id');

		$action_id = \Action::whereName( $action )->pluck('id');

		$role_id = \Auth::user()->role_id;

		try
		{
			$permission = \Permission::
			where("entity_id" , $entity_id )
				->where("action_id" , $action_id )
				->where("role_id" , $role_id )
				->firstOrFail();

		}catch(ModelNotFoundException $e)
		{

			return false;

		}


		return true;

	}

	static function checkBySlug($entity_slug , $action_slug , $role_slug)

	{

		$entity_id = \Entity::where( 'slug' , $entity_slug )->pluck('id');

		$action_id = \Action::where( 'slug' , $action_slug )->pluck('id');

		$role_id = \Role::where( 'slug' , $role_slug )->pluck('id');

		$permission = \Permission::where("entity_id" , $entity_id )
								->where("action_id" , $action_id )
								->where("role_id" , $role_id )
								->first();

		return ($permission == true);
	}

	public function find($id)
	{
		return parent::find($id);
	}

}