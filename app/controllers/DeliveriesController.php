<?php

use Vitem\Repositories\SaleRepo;
use Vitem\Managers\DeliveryManager;
use Vitem\WebServices\DeliveryWebServices as DeliveryAPI;

class DeliveriesController extends \BaseController {

	protected $SaleRepo;

	public function __construct(SaleRepo $SaleRepo)
	{

		$this->SaleRepo = $SaleRepo;

		$this->beforeFilter('ACL:Delivery,Read', ['only' => [ 'index' , 'show' ] ]);

		$this->beforeFilter('ACL:Delivery,Read,true', ['only' => [ 'API'] ]);

		$this->beforeFilter('ACL:Delivery,Create', ['only' => [ 'create' , 'store' ] ]);

		$this->beforeFilter('ACL:Delivery,Update', [ 'only' => [ 'edit' , 'update' ] ]);

		$this->beforeFilter('ACL:Delivery,Delete', [ 'only' => 'destroy' ] );
		
	}


	/**
	 * Display a listing of the resource.
	 * GET /deliveries
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /deliveries/create
	 *
	 * @return Response
	 */
	public function create($sale_id = false)
	{ 
		$types = [

			'1' => 'Código postal',
			'2' => 'Colonia',
			'3' => 'Delegación/Municipio',
			'4' => 'Estado'

		];


		if($sale_id)
		{

			$sale = $this->SaleRepo->find($sale_id);

			if(!$sale)
			{
				Session::flash('error' , 'La venta especificada no existe');

            	return Redirect::route('sales.index');
			}
		}

		return View::make('deliveries/create' , compact('sale_id', 'types' ))
					->with(
						[
							'newDestination' => false
						]
					);
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /deliveries
	 *
	 * @return Response
	 */
	public function store()
	{
		$data = Input::all(); 

		$createDelivery = new DeliveryManager( $data );		

		$response = $createDelivery->save();

			if($response['success'])
	        {
	        	Session::flash('success' , 'La entrega se ha guardado correctamente.');

	            return Redirect::route('sales.show' , [$data['sale_id']]);
	        }
	        else
	        {

	            Session::flash('error' , 'Existen errores en el formulario.');

	            //dd($response);

	            return Redirect::back()
	            		->withErrors($response['errors'])
	            		->withInput()
	            		->with(
	            			[ 'newDestination' => (isset($response['newDestination'])) ? 1 : 0]
	            		);

	        }
	}

	/**
	 * Display the specified resource.
	 * GET /deliveries/{id}
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
	 * GET /deliveries/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$delivery =  Delivery::find($id);

		if(!$delivery)
		{
			
			Session::flash('error' , 'La entrega especificada no existe.');

	        return Redirect::route('sales.index');

		} 

		$types = [

			'1' => 'Código postal',
			'2' => 'Colonia',
			'3' => 'Delegación/Municipio',
			'4' => 'Estado'

		];
		
		return View::make('deliveries/edit', compact('id' , 'delivery' , 'types'));
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /deliveries/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		
		$delivery =  Delivery::find($id);

		if(!$delivery)
		{
			Session::flash('error' , 'La entrega especificada no existe.');

        	return Redirect::route('sales.index' );
		}

		$data = Input::all(); 

        $data['id'] = (int) $id;

        $data['sale_id'] = $delivery->sale_id;

		$updateDelivery = new DeliveryManager( $data );

        $response = $updateDelivery->update();

        if($response['success'])
        {
        	Session::flash('success' , 'La entrega se ha actualizado correctamente.');

            return Redirect::route('sales.show' , [$delivery->sale_id] );
        }
        else
        {

            Session::flash('error' , 'Existen errores en el formulario.');

            return Redirect::back()
	            		->withErrors($response['errors'])
	            		->withInput()
	            		->with(
	            			[ 'newDestination' => (isset($response['newDestination'])) ? true : false]
	            		);

        }

	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /deliveries/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$delivery = Delivery::find($id);

		if(!$delivery)
		{
			Session::flash('error' , 'La entrega especificada no existe.');

        	return Redirect::route('sales.index');
		}

		Delivery::destroy($id);

	    Session::flash('success' , 'La entrega se ha eliminado correctamente.');

        return Redirect::route('sales.show' , [$delivery->sale_id] );
	}

	public function API( $method = 'all')
	{

		return DeliveryAPI::$method();

	}

}