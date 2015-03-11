<?php

use Vitem\Repositories\SupplierRepo;
use Vitem\Managers\SupplierManager;
use Vitem\WebServices\SupplierWebServices as SupplierAPI;

class SuppliersController extends \BaseController {

	public function __construct()
	{

		$this->beforeFilter('ACL:Supplier,Read', ['only' => [ 'index' , 'show' ] ]);

		$this->beforeFilter('ACL:Supplier,Read,true', ['only' => [ 'API'] ]);

		$this->beforeFilter('ACL:Supplier,Create', ['only' => [ 'create' , 'store' ] ]);

		$this->beforeFilter('ACL:Supplier,Update', [ 'only' => [ 'edit' , 'update' ] ]);

		$this->beforeFilter('ACL:Supplier,Delete', [ 'only' => 'destroy' ] );
		
	}

	/**
	 * Display a listing of the resource.
	 * GET /suppliers
	 *
	 * @return Response
	 */
	public function index()
	{
		$statuses = [
			0 => 'Inactivo' ,
			1 => 'Activo'
		];

		return View::make('suppliers/index', compact( 'statuses' ));
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /suppliers/create
	 *
	 * @return Response
	 */
	public function create()
	{
		
		return View::make('suppliers/create');

	}

	/**
	 * Store a newly created resource in storage.
	 * POST /suppliers
	 *
	 * @return Response
	 */
	public function store()
	{
		$supplierData = Input::all();   

		$createSupplier = new SupplierManager( $supplierData );

        $response = $createSupplier->save();

		if (Request::ajax()){

			return Response::json($response , 200);

		}
		else {

			if ($response['success']) {
				Session::flash('success', 'El proveedor se ha guardado correctamente.');

				return Redirect::route('suppliers.index');
			} else {

				Session::flash('error', 'Existen errores en el formulario.');

				return Redirect::back()->withErrors($response['errors'])->withInput();

			}

		}
	}

	/**
	 * Display the specified resource.
	 * GET /suppliers/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$supplier =  SupplierRepo::with(['products'])->find($id);

		if(!$supplier)
		{
			Session::flash('error' , 'El proovedor no existe.');

        	return Redirect::route('suppliers.index');
		}
		
		return View::make('suppliers/show', compact('supplier'));
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /suppliers/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$supplier =  Supplier::find($id);

		if(!$supplier)
		{
			Session::flash('error' , 'El proveedor no existe.');

        	return Redirect::route('suppliers.index');
		}
		
		return View::make('suppliers/edit')->withSupplier($supplier);
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /suppliers/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$supplier =  Supplier::find($id);

		if(!$supplier)
		{
			Session::flash('error' , 'El proveedor no existe.');

        	return Redirect::route('suppliers.index');
		}

		$data = Input::all(); 

        $data['id'] = $id;


		$updateSupplier = new SupplierManager( $data );

        $response = $updateSupplier->update();

        if($response['success'])
        {
        	Session::flash('success' , 'El proveedor se ha actualizado correctamente.');

            return Redirect::route('suppliers.index');
        }
        else
        {

            Session::flash('error' , 'Existen errores en el formulario.');

            return Redirect::back()->withErrors($response['errors'])->withInput();

        }
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /suppliers/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$supplier = Supplier::find($id);

		if(!$supplier)
		{
			Session::flash('error' , 'El proveedor no existe.');

        	return Redirect::route('suppliers.index');
		}

		Supplier::destroy($id);

	    Session::flash('success' , 'El proveedor se ha eliminado correctamente.');

        return Redirect::route('suppliers.index');
	}


	public function API( $method = 'all')
	{

		return SupplierAPI::{$method}();

	}

}