<?php

use Vitem\Repositories\UserRepo;
use Vitem\WebServices\UserWebServices as UserAPI;
use Vitem\Managers\UserManager;


class UsersController extends \BaseController {

	//protected $userRepo;

	public function __construct()
	{

		$this->beforeFilter('ACL:User,Read', ['only' => [ 'index' , 'show' ] ]);

		$this->beforeFilter('ACL:User,Read,true', ['only' => [ 'API'] ]);

		$this->beforeFilter('ACL:User,Create', ['only' => [ 'create' , 'store' ] ]);

		$this->beforeFilter('ACL:User,Update', [ 'only' => [ 'edit' , 'update' ] ]);

		$this->beforeFilter('ACL:User,Delete', [ 'only' => 'destroy' ] );
		
	}

	/**
	 * Display a listing of the resource.
	 * GET /users
	 *
	 * @return Response
	 */
	public function index()
	{		

		$roles = Role::lists('name' , 'id' );

		$statuses = [
			'0' => 'Inactivo',
			'1' => 'Activo'
		];

		$filtersSalary = [
			'<' => 'Menor a',
			'==' => 'Igual a',
			'>' => 'Mayor a'
 		];

 		$filtersEntryDate = [
			'<' => 'Antes de',
			'==' => 'El dia',
			'>' => 'Después de'
 		];

		return View::make('users/index', compact('roles', 'filtersSalary', 'filtersEntryDate' , 'statuses'));
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /users/create
	 *
	 * @return Response
	 */
	public function create()
	{
		$roles = Role::lists('name' , 'id' );

		$stores = Store::lists('name' , 'id' );

		$employee_types = EmployeeType::lists('name' , 'id' );
		
		return View::make('users/create', compact('roles' , 'employee_types' , 'stores'));

	}

	/**
	 * Store a newly created resource in storage.
	 * POST /users
	 *
	 * @return Response
	 */
	public function store()
	{

		$userData = Input::only('username','email','password', 'password_confirmation' , 'name','street' , 'outer_number','inner_number','zip_code','colony','city','state','phone','role_id' ,'store_id','status' ,'image_profile');        

        $employeeData = Input::only('salary', 'entry_date');

        $data = [
        	'User' => $userData,
        	'Employee' => $employeeData        
        ];        


		$createUser = new UserManager( $data );

        $response = $createUser->save();

        if($response['success'])
        {
        	Session::flash('success' , 'El usuario se ha guardado correctamente.');

            return Redirect::route('users.index');
        }
        else
        {

            Session::flash('error' , 'Existen errores en el formulario.');

            return Redirect::back()->withErrors($response['errors'])->withInput();

        }
	}

	/**
	 * Display the specified resource.
	 * GET /users/{id}
	 *
	 * @param  int  $id	 * @return Response
	 */
	public function show($id)
	{
		$user =  UserRepo::with(['employee.sales' , 'employee.commissions' , 'employee.deliveries.sale' , 'employee.deliveries.destination'] )->find($id);

		if(!$user)
		{
			Session::flash('error' , 'El usuario no existe.');

        	return Redirect::route('users.index');
		}

		$roles = Role::lists('name' , 'id' );

		$employee_types = EmployeeType::lists('name' , 'id' );

		$sale_types = [
			'apartado' => 'Apartado',
			'contado' => 'Contado'
		];

		$pay_types = [
			'efectivo' => 'Efectivo',
			'tarjeta' => 'Tarjeta',
			'cheque' => 'Cheque'
		];

		$filtersSaleDate = [
			'<' => 'Antes de',
			'==' => 'El dia',
			'>' => 'Después de'
 		];
		
		return View::make('users/show', compact('roles' , 'employee_types' , 'user' , 'sale_types' , 'pay_types' , 'filtersSaleDate'));
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /users/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$user =  User::with('Employee')->find($id);

		if(!$user)
		{
			Session::flash('error' , 'El usuario no existe.');

        	return Redirect::route('users.index');
		}
		
		$roles = Role::lists('name' , 'id' );

		$stores = Store::lists('name' , 'id' );

		$employee_types = EmployeeType::lists('name' , 'id' );
		
		return View::make('users/edit', compact('roles' , 'employee_types' , 'stores'))->withUser($user);
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /users/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{

		$user =  User::find($id);

		if(!$user)
		{
			Session::flash('error' , 'El usuario no existe.');

        	return Redirect::route('users.index');
		}

		$userData = Input::only('username','email','password', 'password_confirmation' , 'name','street' , 'outer_number','inner_number','zip_code','colony','city','state','phone','role_id' ,'store_id' ,'status' ,'image_profile');        

        $employeeData = Input::only('salary' , 'entry_date');

        $data = [
        	'User' => $userData,
        	'Employee' => $employeeData        
        ];        

        $data['User']['id'] = $id;


		$updateUser = new UserManager( $data );

        $response = $updateUser->update();

        if($response['success'])
        {
        	Session::flash('success' , 'El usuario se ha actualizado correctamente.');

            return Redirect::route('users.index');
        }
        else
        {

            Session::flash('error' , 'Existen errores en el formulario.');

            return Redirect::back()->withErrors($response['errors'])->withInput();

        }
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /users/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$user = User::find($id);

		if(!$user)
		{
			Session::flash('error' , 'El usuario no existe.');

        	return Redirect::route('users.index');
		}

		$deleteUser = new UserManager( $user );

        $response = $deleteUser->destroy();

        if($response['success'])
        {
        	Session::flash('success' , 'El usuario se ha eliminado correctamente.');

            return Redirect::route('users.index');
        }
        else
        {

            Session::flash('error' , $response['errors']);

            return Redirect::route('users.index');

        }

		/*User::destroy($id);

	    Session::flash('success' , 'El usuario se ha eliminado correctamente.');

        return Redirect::route('users.index');*/
	}

	public function API($method = 'all')
	{
		return UserAPI::$method();

	}

}