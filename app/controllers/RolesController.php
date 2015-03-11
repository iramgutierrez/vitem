<?php

use Vitem\Managers\RoleManager;
use Vitem\WebServices\RoleWebServices as RoleAPI;

class RolesController extends \BaseController {

	public function __construct()
	{

		$this->beforeFilter('ACL:Role,Read', ['only' => [ 'index' , 'show' ] ]);

		$this->beforeFilter('ACL:Role,Read,true', ['only' => [ 'API'] ]);

		$this->beforeFilter('ACL:Role,Create', ['only' => [ 'create' , 'store' ] ]);

		$this->beforeFilter('ACL:Role,Update', [ 'only' => [ 'edit' , 'update' ] ]);

		$this->beforeFilter('ACL:Role,Delete', [ 'only' => 'destroy' ] );
		
	}

	/**
	 * Display a listing of the resource.
	 * GET /roles
	 *
	 * @return Response
	 */
	public function index()
	{
		
		return View::make('roles/index');

	}

	/**
	 * Show the form for creating a new resource.
	 * GET /roles/create
	 *
	 * @return Response
	 */
	public function create()
	{

		$levels = Level::with('Role')->get();

		return View::make('roles/create' , compact('levels'));
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /roles
	 *
	 * @return Response
	 */
	public function store()
	{
		$data = Input::all(); 

		$createRole = new RoleManager( $data );		

        $response = $createRole->save();

        if($response['success'])
        {
        	Session::flash('success' , 'El rol se ha guardado correctamente.');

            return Redirect::route('roles.index');
        }
        else
        {

            Session::flash('error' , 'Existen errores en el formulario.');

            return Redirect::back()->withErrors($response['errors'])->withInput();

        }
	}

	/**
	 * Display the specified resource.
	 * GET /roles/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$role =  Role::find($id);

		if(!$role)
		{
			Session::flash('error' , 'El rol no existe.');

        	return Redirect::route('roles.index');
		}
		
		return View::make('roles/show', compact('role'));
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /roles/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$role =  Role::find($id);

		$levels = Level::with('Role')->get();

		if(!$role)
		{
			Session::flash('error' , 'El rol no existe.');

        	return Redirect::route('roles.index');
		}

		return View::make('roles/edit' ,compact('role' , 'levels') );
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /roles/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$role =  Role::find($id);

		if(!$role)
		{
			Session::flash('error' , 'El rol no existe.');

        	return Redirect::route('roles.index');
		}

		$data = Input::all(); 

        $data['id'] = $id;

		$updateRole = new RoleManager( $data );

        $response = $updateRole->update();

        if($response['success'])
        {
        	Session::flash('success' , 'El rol se ha actualizado correctamente.');

            return Redirect::route('roles.index');
        }
        else
        {

            Session::flash('error' , 'Existen errores en el formulario.');

            return Redirect::back()->withErrors($response['errors'])->withInput();

        }

	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /roles/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$data = Input::all();

		$data['id'] = (int) $id;

		$role = Role::find($id);

		if(!$role)
		{
			Session::flash('error' , 'El rol especificada no existe.');

        	return Redirect::route('roles.index');
		}

		$deleteRole = new RoleManager( $data );		

        $response = $deleteRole->delete();

        if($response)
        {
        	Session::flash('success' , 'El rol se ha eliminado correctamente.');

            return Redirect::route('roles.index');
        }
        else
        {

            Session::flash('error' , 'No ha sido posible eliminar el rol.');

            return Redirect::back()->withErrors($response['errors'])->withInput();

        }
	}

	public function API($method = 'all')
	{
		return RoleAPI::$method();

	}

}