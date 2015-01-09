<?php

use Vitem\Managers\SaleManager;
use Vitem\WebServices\SaleWebServices as SaleAPI;

class SalesController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /sales
	 *
	 * @return Response
	 */
	public function index()
	{
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


		return View::make('sales/index',compact('sale_types' , 'pay_types' , 'filtersSaleDate'));
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /sales/create
	 *
	 * @return Response
	 */
	public function create()
	{

		$sales_types = [

			'contado' => 'Contado',
			'apartado' => 'Apartado'
 
		];

		$pay_types = [

			'efectivo' => 'Efectivo',
			'tarjeta' => 'Tarjeta',
			'cheque' => 'Cheque'
 
		];

		$destination_types = [

			'1' => 'Código postal',
			'2' => 'Colonia',
			'3' => 'Delegación/Municipio',
			'4' => 'Estado'

		];


		return View::make('sales/create' , compact('sales_types' , 'pay_types' , 'destination_types'))->render();
		
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /sales
	 *
	 * @return Response
	 */
	public function store()
	{ 
		$data = Input::all(); 

		$createSale = new SaleManager( $data );		

        $response = $createSale->save();

        if($response['success'])
        {
        	Session::flash('success' , 'La venta se ha guardado correctamente.');

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
	 * GET /sales/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$sale =  Sale::with('products')
					 ->with('packs')
					 ->with('sale_payments')
					 ->with('sale_payments.employee')
					 ->with('sale_payments.employee.user')
					 ->with('commissions')
					 ->with('commissions.sale_payments')
					 ->with('commissions.employee.user')
					 ->with('delivery.employee.user')
					 ->with('client')
					 ->with('employee')
					 ->find($id);	

		if(!$sale)
		{
			Session::flash('error' , 'La venta no existe.');

        	return Redirect::route('sales.index');
		}
		
		return View::make('sales/show', compact('sale' ));
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /sales/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$sale =  Sale::with('products')
					 ->with('packs')
					 ->with('sale_payments')
					 ->with('sale_payments.employee')
					 ->with('sale_payments.employee.user')
					 ->with('commissions')
					 ->with('commissions.sale_payments')
					 ->with('commissions.employee.user')
					 ->with('delivery.employee.user')
					 ->with('client')
					 ->with('employee')
					 ->find($id);

		if(!$sale)
		{
			Session::flash('error' , 'La venta no existe.');

        	return Redirect::route('sales.index');
		}

		$sales_types = [

			'contado' => 'Contado',
			'apartado' => 'Apartado'
 
		];

		$pay_types = [

			'efectivo' => 'Efectivo',
			'tarjeta' => 'Tarjeta',
			'cheque' => 'Cheque'
 
		];

		$productsJson = $sale->products->toJson();

		return View::make('sales/edit', compact('sale' , 'sales_types' , 'pay_types' , 'productsJson'));
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /sales/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{

		
		$sale =  Sale::with('products')
					 ->with('packs')
					 ->with('client')
					 ->with(['employee' , 'employee.user'])
					 ->find($id);

		if(!$sale)
		{
			Session::flash('error' , 'La venta no existe.');

        	return Redirect::route('sales.index');
		}

		$data = Input::all(); 

        $data['id'] = (int) $id;


		$updateSale = new SaleManager( $data );

        $response = $updateSale->update();

        if($response['success'])
        {
        	Session::flash('success' , 'La venta se ha actualizado correctamente.');

            return Redirect::route('sales.index');
        }
        else
        {

            Session::flash('error' , 'Existen errores en el formulario.');

            return Redirect::back()->withErrors($response['errors'])->withInput();

        }
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /sales/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$data = Input::only('add_stock');

		$data['id'] = (int) $id;

		$sale =  Sale::with('products')
					 ->with('packs')
					 ->with('client')
					 ->with('employee')
					 ->find($id);

		if(!$sale)
		{
			Session::flash('error' , 'La venta no existe.');

        	return Redirect::route('sales.index');
		}

		$deleteSale = new SaleManager( $data );		

        $response = $deleteSale->delete();

        if($response)
        {
        	Session::flash('success' , 'La venta se ha eliminado correctamente.');

            return Redirect::route('sales.index');
        }
        else
        {

            Session::flash('error' , 'No ha sido posible eliminar la venta.');

            return Redirect::back()->withErrors($response['errors'])->withInput();

        }

	}


	public function API( $method = 'all')
	{

		return SaleAPI::{$method}();

	}

}