<?php

use Vitem\Managers\SalePaymentManager;

class SalePaymentsController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /salepayments
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /salepayments/create
	 *
	 * @return Response
	 */
	public function create($sale_id = false)
	{

		$pay_types = [

			'efectivo' => 'Efectivo',
			'tarjeta' => 'Tarjeta',
			'cheque' => 'Cheque'
 
		];

		if($sale_id)
		{

			$sale = Sale::find($sale_id);

			if(!$sale)
			{
				Session::flash('error' , 'La venta especificada no existe');

            	return Redirect::route('sales.index');
			}
		}

		return View::make('sale_payments/create' , compact('pay_types' ,'sale_id'));
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /salepayments
	 *
	 * @return Response
	 */
	public function store()
	{
		$salePaymentData = Input::all();   

		$createSalePayment = new SalePaymentManager( $salePaymentData );

        $response = $createSalePayment->save();

        if($response['success'])
        {
        	Session::flash('success' , 'El abono se ha guardado correctamente.');

            return Redirect::route('sales.show' , [$response['sale_id'] ]);
        }
        else
        {

            Session::flash('error' , 'Existen errores en el formulario.');

            return Redirect::back()->withErrors($response['errors'])->withInput();

        }
	}

	/**
	 * Display the specified resource.
	 * GET /salepayments/{id}
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
	 * GET /salepayments/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$sale_payment =  SalePayment::find($id);
		
		$pay_types = [

			'efectivo' => 'Efectivo',
			'tarjeta' => 'Tarjeta',
			'cheque' => 'Cheque'
 
		];

		$sale_id = $sale_payment->sale_id;
		
		return View::make('sale_payments/edit', compact('sale_payment' , 'pay_types' , 'sale_id'));
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /salepayments/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$sale_payment =  SalePayment::with('sale')->find($id);

		if(!$sale_payment)
		{
			Session::flash('error' , 'El abono no existe.');

        	return Redirect::route('sales.index');
		}

		$salePaymentData = Input::all(); 

        $salePaymentData['id'] = (int) $id;

		$updateSalePayment = new SalePaymentManager( $salePaymentData );

        $response = $updateSalePayment->update();

        if($response['success'])
        {
        	Session::flash('success' , 'El abono se ha actualizado correctamente.');

            return Redirect::route('sales.show', [$sale_payment->sale_id]);
        }
        else
        {

            Session::flash('error' , 'Existen errores en el formulario.');

            return Redirect::back()->withErrors($response['errors'])->withInput();

        }
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /salepayments/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$data = Input::all();

		$data['id'] = (int) $id;

		$sale_payment = SalePayment::find($id);

		if(!$sale_payment)
		{
			Session::flash('error' , 'El abono especificada no existe.');

        	return Redirect::route('sales.index');
		}

		$deleteSalePayment = new SalePaymentManager( $data );		

        $response = $deleteSalePayment->delete();

        if($response)
        {
        	Session::flash('success' , 'El abono se ha eliminado correctamente.');

            return Redirect::route('sales.show' , [$sale_payment->sale_id] );
        }
        else
        {

            Session::flash('error' , 'No ha sido posible eliminar el abono.');

            return Redirect::back()->withErrors($response['errors'])->withInput();

        }
        
	}

}