<?php namespace Vitem\Repositories;

use Illuminate\Database\Eloquent\ModelNotFoundException;

class PermissionRepo extends BaseRepo {

	/*public function getModel()
	{
		
	}*/

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

	public function find($id)
	{
		return parent::find($id);
	}

}