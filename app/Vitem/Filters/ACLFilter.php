<?php namespace Vitem\Filters;

use Vitem\Repositories\PermissionRepo as PermissionRepo;


class ACLFilter
{

	protected $PermissionRepo;


	public function __construct(PermissionRepo $PermissionRepo)
	{

		$this->PermissionRepo = $PermissionRepo;

	}

	public function check($route, $request, $entity, $action , $json = false)
	{ 
		if (\Auth::check()) { 

			$user_id = \Auth::user()->id;

			$role_id = \Auth::user()->role_id;

			$level_id = \Auth::user()->role->level_id;

			$permission = $this->PermissionRepo->check($entity, $action, $role_id );

			if (!$permission) {

				if(!$json)
				{

					\Session::flash('error', 'No tienes permisos de ' . \Lang::get('messages.'.strtolower($action)) . ' ' . \Lang::get('messages.'.strtolower($entity)));

					return \Redirect::route('dashboard');
				}else{

					return \Response::json([]);
				}

			}

			$segment_2 = \Request::segment(2);

			if($segment_2 && is_numeric($segment_2)) {

				if(in_array($entity , ['User' , 'Commission', 'SalePayment' , 'Delivery' , 'Expense' , 'Sale'])){		

					$entity_user_id = false;

					$entity_store_id = false;

					if ($entity == 'User') {

						$entity_user_id = $segment_2;

					} else{

						$record = $entity::where('id', $segment_2)->first();

						if(!empty($record->employee_id))
							$entity_user_id = $record->employee_id;

					}

					if(in_array($entity , ['User' , 'Sale']))
					{
						$record = $entity::where('id', $segment_2)->first();

						if(!empty($record->store_id))
							$entity_store_id = $record->store_id;
					}else{

						$record = $entity::where('id', $segment_2)->first();

						if(!empty($record->sale->store_id))
							$entity_store_id = $record->sale->store_id;

					}

					$usersPermitted = self::generateAuthCondition();

					$storesPermitted = self::generateStoreCondition();

					if ( ( !in_array($entity_user_id, $usersPermitted) && $entity_user_id ) || (!in_array($entity_store_id, $storesPermitted) && $entity_store_id) ) {

						if(!$json)
						{

							\Session::flash('error', 'No tienes permisos de ' . \Lang::get('messages.'.strtolower($action)) . ' este ' . \Lang::get('messages.singular.'.strtolower($entity)));

							return \Redirect::route('dashboard');
						}else{

							return \Response::json([]);
						}
							
					}

				}

			}

		}

	}

	static function generateAuthCondition()
	{

		$user = \Auth::user();

		$level_id = $user->role->level_id; 

		$whereUserId = [];

		switch($level_id)
		{

			case 1:
				$whereUserId[] = $user->id;
				break;
			case 2:
				$whereUserId[] = $user->id;

				$usersWithLevel1 = \User::whereIn('role_id', function($query)
				{
					$query->select(\DB::raw('id'))
						->from('roles')
						->whereRaw('roles.level_id = 1');
				})
					->lists('id');

				$whereUserId = array_merge($whereUserId, $usersWithLevel1);



				break;

			case 3:
				$whereUserId[] = $user->id;

				$usersWithLevel1 = \User::whereIn('role_id', function($query)
				{
					$query->select(\DB::raw('id'))
						->from('roles')
						->whereRaw('roles.level_id = 1');
				})
					->lists('id');

				$whereUserId = array_merge($whereUserId, $usersWithLevel1);

				$usersWithLevel2 = \User::whereIn('role_id', function($query)
				{
					$query->select(\DB::raw('id'))
						->from('roles')
						->whereRaw('roles.level_id = 2');
				})
					->lists('id');

				$whereUserId = array_merge($whereUserId, $usersWithLevel2);

				break;

			case 4:
				$whereUserId = \User::lists('id');

				break;

		}

		return $whereUserId;

	}

	static function generateStoreCondition()
	{

		$user = \Auth::user();

		$level_id = $user->role->level_id; 

		$whereStoreId = [];

		switch($level_id)
		{

			case 1:
				$whereStoreId[] = $user->store_id;

				break;
			case 2:
				$whereStoreId[] = $user->store_id;

				break;

			case 3:
				$whereStoreId = \Store::lists('id');

				break;

			case 4:
				$whereStoreId = \Store::lists('id');

				break;

		}

		return $whereStoreId;

	}

}