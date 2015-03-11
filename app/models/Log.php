<?php 

//use Vitem\Repositories\PermissionRepo;

class Log extends Eloquent {	

	protected $fillable = ['user_id' , 'type' , 'entity' , 'entity_id' , 'message' , 'object'];
}