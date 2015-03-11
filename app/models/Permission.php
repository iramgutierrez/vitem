<?php 

//use Vitem\Repositories\PermissionRepo;

class Permission extends Eloquent {

	protected $PermissionRepo;


	/*public function __construct(PermissionRepo $PermissionRepo)
	{

		$this->PermissionRepo = $PermissionRepo;

	}*/

	public function Role()
	{
		return $this->belongsTo('Role');
	}

	public function Action()
	{
		return $this->belongsTo('Action');
	}

	public function Entity()
	{
		return $this->belongsTo('Entity');
	}

	protected $fillable = ['role_id' , 'action_id' , 'entity_id'];


	static function check( $entity_id , $action_id , $role_id){

		$PermissionRepo = new PermissionRepo();
		
		return $PermissionRepo->check( $entity_id , $action_id , $role_id );

	}
}