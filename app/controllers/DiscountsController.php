<?php


use Vitem\Managers\DiscountManager;

class DiscountsController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /discounts
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /discounts/create
	 *
	 * @return Response
	 */
	public function create()
	{

        $types = [
            '1' => 'Por producto/paquete',
            '2' => 'Por venta'
        ];

        return View::make('discounts/create' , compact('types'));
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /discounts
	 *
	 * @return Response
	 */
	public function store()
	{
        $data = Input::all();

        $createDiscount = new DiscountManager( $data );

        $response = $createDiscount->save();
        if($response['success'])
        {
            Session::flash('success' , 'El descuento se ha guardado correctamente.');

            return Redirect::route('discounts.show' , [$response['return_id']]);
        }
        else
        {

            return Redirect::back()
                ->withErrors($response['errors'])
                ->withInput();

        }
	}

	/**
	 * Display the specified resource.
	 * GET /discounts/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{   echo "<pre>";
		dd(Discount::with('item' , 'stores' , 'pay_types')->find($id)->toArray());
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /discounts/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /discounts/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /discounts/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}