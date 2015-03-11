<?php

use Vitem\Repositories\SaleRepo;
use Vitem\Managers\CommissionManager;
use Vitem\WebServices\CommissionWebServices as CommissionAPI;

class CommissionsController extends \BaseController {

	protected $SaleRepo;

	public function __construct(SaleRepo $SaleRepo)
	{

		$this->SaleRepo = $SaleRepo;

		$this->beforeFilter('ACL:Commission,Read', ['only' => [ 'index' , 'show' ] ]);

		$this->beforeFilter('ACL:Commission,Read,true', ['only' => [ 'API'] ]);

		$this->beforeFilter('ACL:Commission,Create', ['only' => [ 'create' , 'store' ] ]);

		$this->beforeFilter('ACL:Commission,Update', [ 'only' => [ 'edit' , 'update' ] ]);

		$this->beforeFilter('ACL:Commission,Delete', [ 'only' => 'destroy' ] );
		
	}

	/**
	 * Display a listing of the resource.
	 * GET /commissions
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /commissions/create
	 *
	 * @return Response
	 */
	public function create($sale_id = false , $employee_id = false)
	{ 
		
		if($sale_id)
		{

			$sale = $this->SaleRepo->find($sale_id);

			if(!$sale)
			{
				Session::flash('error' , 'La venta especificada no existe');

            	return Redirect::route('sales.index');
			}
		}

		return View::make('commissions/create' , compact('sale_id' , 'employee_id'));
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /commissions
	 *
	 * @return Response
	 */
	public function store()
	{
		$data = Input::all(); 

		$createCommission = new CommissionManager( $data );		

		if(isset($data['Commissions']))
		{
			$response = $createCommission->saveAll();

			if(isset($response['1'])){

				if($response['1'] > 1)
				{
					$success_message = 'Se guardaron correctamente ' . $response['1'] . ' comisiones.';
				}
				else
				{
					$success_message = 'Se guardo correctamente ' . $response['1'] . ' comisión.';
				}

				Session::flash('success' , $success_message );
			
			}

			if(isset($response['0'] ) ){

				if($response['0'] > 1)
				{
					$error_message = 'Error al intentar guardar ' . $response['0'] . ' comisiones.';
				}
				else
				{
					$error_message = 'Error al intentar guardar ' . $response['0'] . ' comisión.';
				}

				Session::flash('error' , $error_message);
			}

			return Redirect::route('sales.show' , [$data['sale_id']]);

		}
		else
		{
			$response = $createCommission->save();

			if($response['success'])
	        {
	        	Session::flash('success' , 'La comisión se ha guardado correctamente.');

	            return Redirect::route('sales.show' , [$data['sale_id']]);
	        }
	        else
	        {

	            Session::flash('error' , 'Existen errores en el formulario.');

	            return Redirect::back()->withErrors($response['errors'])->withInput();

	        }
		}       

        
	}

	/**
	 * Display the specified resource.
	 * GET /commissions/{id}
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
	 * GET /commissions/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$commission =  Commission::find($id);

		if(!$commission)
		{
			
			Session::flash('error' , 'La comisión especificada no existe.');

	        return Redirect::route('sales.index');

		} 
		
		return View::make('commissions/edit', compact('id' , 'commission'));
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /commissions/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$commission =  Commission::find($id);

		if(!$commission)
		{
			Session::flash('error' , 'La comisión no existe.');

        	return Redirect::route('sales.index' );
		}

		$data = Input::all(); 

        $data['id'] = (int) $id;


		$updateCommission = new CommissionManager( $data );

        $response = $updateCommission->update();

        if($response['success'])
        {
        	Session::flash('success' , 'La comisión se ha actualizado correctamente.');

            return Redirect::route('sales.show' , [$commission->sale_id] );
        }
        else
        {

            Session::flash('error' , 'Existen errores en el formulario.');

            return Redirect::back()->withErrors($response['errors'])->withInput();

        }
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /commissions/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{

		$data = Input::all();

		$data['id'] = (int) $id;

		$commission = Commission::find($id);

		if(!$commission)
		{
			Session::flash('error' , 'La comisión especificada no existe.');

        	return Redirect::route('sales.index');
		}

		$deleteCommission = new CommissionManager( $data );		

        $response = $deleteCommission->delete();

        if($response)
        {
        	Session::flash('success' , 'La comisión se ha eliminado correctamente.');

            return Redirect::route('sales.show' , [$commission->sale_id] );
        }
        else
        {

            Session::flash('error' , 'No ha sido posible eliminar la comisión.');

            return Redirect::back()->withErrors($response['errors'])->withInput();

        }
        
	}

	public function API( $method = 'all')
	{

		return CommissionAPI::{$method}();

	}

}