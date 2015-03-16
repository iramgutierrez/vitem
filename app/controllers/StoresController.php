<?php

use Vitem\Repositories\StoreRepo;
use Vitem\Managers\StoreManager;
use Vitem\WebServices\StoreWebServices as StoreAPI;


class StoresController extends \BaseController {	

	protected $api;

	public function __construct(StoreAPI $StoreAPI)
	{
		$this->api = $StoreAPI;

		/*$this->beforeFilter('ACL:Order,Read', ['only' => [ 'index' , 'show' ] ]);

		$this->beforeFilter('ACL:Order,Read,true', ['only' => [ 'API'] ]);

		$this->beforeFilter('ACL:Order,Create', ['only' => [ 'create' , 'store' ] ]);

		$this->beforeFilter('ACL:Order,Update', [ 'only' => [ 'edit' , 'update' ] ]);

		$this->beforeFilter('ACL:Order,Delete', [ 'only' => 'destroy' ] );*/
		
	}

	/**
	 * Display a listing of the resource.
	 * GET /stores
	 *
	 * @return Response
	 */
	public function index()
	{

		return View::make('stores/index');
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /stores/create
	 *
	 * @return Response
	 */
	public function create()
	{		

		return View::make('stores/create');
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /stores
	 *
	 * @return Response
	 */
	public function store()
	{
		$data = Input::all(); 

		$createStore = new StoreManager( $data );		

        $response = $createStore->save();

        if($response['success'])
        {
        	Session::flash('success' , 'La sucursal se ha guardado correctamente.');

            return Redirect::route('stores.index');
        }
        else
        {

            Session::flash('error' , 'Existen errores en el formulario.');

            return Redirect::back()->withErrors($response['errors'])->withInput();

        }
	}

	/**
	 * Display the specified resource.
	 * GET /stores/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /stores/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$store =  Store::find($id);

		if(!$store)
		{
			Session::flash('error' , 'La sucursal especificada no existe.');

        	return Redirect::route('stores.index');
		}
		
		return View::make('stores/edit')->withStore($store);
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /stores/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$store =  Store::find($id);

		if(!$store)
		{
			Session::flash('error' , 'La sucursal no existe.');

        	return Redirect::route('stores.index');
		}

		$data = Input::all(); 

        $data['id'] = $id;

		$updateStore = new StoreManager( $data );

        $response = $updateStore->update();

        if($response['success'])
        {
        	Session::flash('success' , 'La sucursal se ha actualizado correctamente.');

            return Redirect::route('stores.index');
        }
        else
        {

            Session::flash('error' , 'Existen errores en el formulario.');

            return Redirect::back()->withErrors($response['errors'])->withInput();

        }
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /stores/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$data = Input::all();

		$data['id'] = (int) $id;

		$store = Store::find($id);

		if(!$store)
		{
			Session::flash('error' , 'La sucursal especificada no existe.');

        	return Redirect::route('stores.index');
		}

		$deleteStore = new StoreManager( $data );		

        $response = $deleteStore->delete();

        if($response)
        {
        	Session::flash('success' , 'La sucursal se ha eliminado correctamente.');

            return Redirect::route('stores.index');
        }
        else
        {

            Session::flash('error' , 'No ha sido posible eliminar la sucursal.');

            return Redirect::back()->withErrors($response['errors'])->withInput();

        }
	}

	public function API( $method = 'all')
	{

		return $this->api->$method();

	}

	public function change($store = 'all')
	{

		if(Auth::user()->role->level_id >= 3)
		{

			if($store == 'all')
			{

				if (Session::has('current_store'))
				{
				    Session::forget('current_store');
				}

				Session::flash('success' , 'Se cambio de sucursal correctamente.');

			} else if(is_numeric($store))
			{

				$existsStore = Store::find($store);

				if($existsStore)
				{
					Session::put('current_store', $existsStore->toArray());

					Session::flash('success' , 'Se cambio de sucursal correctamente.');

				}
				else
				{
					Session::flash('error' , 'No existe la sucursal especificada.');

				}


			}
			else
			{
				Session::flash('error' , 'No existe la sucursal especificada.');
			}

		}
		else
		{
			Session::flash('error' , 'No tiene permisos para cambiar de sucursales.');
		}

		return Redirect::back();

	}
}