<?php 

//use Vitem\Repositories\PermissionRepo;

class Permission extends Eloquent {

	protected $PermissionRepo;


	/*public function __construct(PermissionRepo $PermissionRepo)
	{

		$this->PermissionRepo = $PermissionRepo;

	}*/

	protected $fillable = [];


	static function check( $entity_id , $action_id , $role_id){

		$PermissionRepo = new PermissionRepo();
		
		return $PermissionRepo->check( $entity_id , $action_id , $role_id );

	}
}