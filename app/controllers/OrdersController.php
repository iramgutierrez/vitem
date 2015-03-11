<?php

use Vitem\Repositories\OrderRepo;
use Vitem\Managers\OrderManager;
use Vitem\WebServices\OrderWebServices as OrderAPI;

class OrdersController extends \BaseController {

	protected $api;

	public function __construct(OrderAPI $OrderAPI)
	{
		$this->api = $OrderAPI;

		$this->beforeFilter('ACL:Order,Read', ['only' => [ 'index' , 'show' ] ]);

		$this->beforeFilter('ACL:Order,Read,true', ['only' => [ 'API'] ]);

		$this->beforeFilter('ACL:Order,Create', ['only' => [ 'create' , 'store' ] ]);

		$this->beforeFilter('ACL:Order,Update', [ 'only' => [ 'edit' , 'update' ] ]);

		$this->beforeFilter('ACL:Order,Delete', [ 'only' => 'destroy' ] );
		
	}

	/**
	 * Display a listing of the resource.
	 * GET /orders
	 *
	 * @return Response
	 */
	
	public function index()
	{

		$filtersOrderDate = [
			'<' => 'Antes de',
			'==' => 'El dia',
			'>' => 'Después de'
 		];

		return View::make('orders/index' , compact('filtersOrderDate'));

	}

	/**
	 * Show the form for creating a new resource.
	 * GET /orders/create
	 *
	 * @return Response
	 */
	public function create()
	{
		$statuses = [
			1 => 'Solicitado',
			2 => 'Recibido'
		];

		return View::make('orders/create', compact( 'statuses' ));
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /orders
	 *
	 * @return Response
	 */
	public function store()
	{
		$data = Input::all(); 

		$createOrder = new OrderManager( $data );		

        $response = $createOrder->save();

        if($response['success'])
        {
        	Session::flash('success' , 'El pedido se ha guardado correctamente.');

            return Redirect::route('sales.index');
        }
        else
        {

            Session::flash('error' , 'Existen errores en el formulario.');

            return Redirect::back()->withErrors($response['errors'])->withInput();

        }
	}

	/**
	 * Display the specified resource.
	 * GET /orders/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$order =  OrderRepo::with(['products' , 'supplier'])->find($id);

		if(!$order)
		{
			Session::flash('error' , 'El pedido no existe.');

        	return Redirect::route('orders.index');
		}
		
		return View::make('orders/show', compact('order'));
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /orders/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$order =  Order::with('products')->find($id);

		if(!$order)
		{
			Session::flash('error' , 'El pedido no existe.');

        	return Redirect::route('orders.index');
		}

		$statuses = [
			1 => 'Solicitado',
			2 => 'Recibido'
		];
		
		return View::make('orders/edit')->withOrder($order)->withStatuses($statuses);
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /orders/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$order =  Order::find($id);

		if(!$order)
		{
			Session::flash('error' , 'El pedido no existe.');

        	return Redirect::route('orders.index');
		}

		$data = Input::all(); 

        $data['id'] = $id;


		$updateOrder = new OrderManager( $data );

        $response = $updateOrder->update();

        if($response['success'])
        {
        	Session::flash('success' , 'El pedido se ha actualizado correctamente.');

            return Redirect::route('orders.index');
        }
        else
        {

            Session::flash('error' , 'Existen errores en el formulario.');

            return Redirect::back()->withErrors($response['errors'])->withInput();

        }
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /orders/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$data = Input::all();

		$data['id'] = (int) $id;

		$order = Order::find($id);

		if(!$order)
		{
			Session::flash('error' , 'El pedido especificada no existe.');

        	return Redirect::route('orders.index');
		}

		$deleteOrder = new OrderManager( $data );		

        $response = $deleteOrder->delete();

        if($response)
        {
        	Session::flash('success' , 'El pedido se ha eliminado correctamente.');

            return Redirect::route('orders.index');
        }
        else
        {

            Session::flash('error' , 'No ha sido posible eliminar el pedido.');

            return Redirect::back()->withErrors($response['errors'])->withInput();

        }
	}


	public function API( $method = 'all')
	{

		return $this->api->$method();

	}

}