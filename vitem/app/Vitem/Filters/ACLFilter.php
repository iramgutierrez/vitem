<?php namespace Vitem\Filters;

use Vitem\Repositories\PermissionRepo as PermissionRepo;


class ACLFilter {

	protected $PermissionRepo;


	public function __construct(PermissionRepo $PermissionRepo)
	{

		$this->PermissionRepo = $PermissionRepo;

	}
	public function check( $route, $request, $entity , $action , $message = 'No tienes permiso para acceder a esta sección.')
	{	
		if (\Auth::check())
		{

			$permission = $this->PermissionRepo->check($entity , $action, \Auth::user()->role_id);	

			if( !$permission )
			{
				\Session::flash('error' , $message);

				return \Redirect::route('dashboard');
			}

		}		
		
	}

}