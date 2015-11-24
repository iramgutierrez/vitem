<?php


use Vitem\Managers\DiscountManager;
use Vitem\WebServices\DiscountWebServices as DiscountAPI;

class DiscountsController extends \BaseController {

    protected $api;

    public function __construct(DiscountAPI $DiscountAPI)
    {
        $this->api = $DiscountAPI;

        /*$this->beforeFilter('ACL:Discount,Read', ['only' => [ 'index' , 'show' ] ]);

        $this->beforeFilter('ACL:Discount,Read,true', ['only' => [ 'API'] ]);

        $this->beforeFilter('ACL:Discount,Create', ['only' => [ 'create' , 'store' ] ]);

        $this->beforeFilter('ACL:Discount,Update', [ 'only' => [ 'edit' , 'update' ] ]);

        $this->beforeFilter('ACL:Discount,Delete', [ 'only' => 'destroy' ] );*/

    }

	/**
	 * Display a listing of the resource.
	 * GET /discounts
	 *
	 * @return Response
	 */
	public function index()
	{
        $types = [
            '1' => 'Por producto/paquete',
            '2' => 'Por venta'
        ];

        $discount_types = [
            'percent' => 'Porcentaje',
            'quantity' => 'Cantidad'
        ];

        $stores = Store::lists('name' , 'id');

        $pay_types = PayType::lists('name' , 'id');

        return View::make('discounts/index' , compact('types' , 'discount_types' , 'stores' , 'pay_types'));
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
	{

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
        $types = [
            '1' => 'Por producto/paquete',
            '2' => 'Por venta'
        ];

        $discount = \Discount::with('stores' , 'pay_types' , 'item' )->find($id);

        return View::make('discounts/edit' , compact('types' , 'discount'));
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
        $discount =  Discount::find($id);

        if(!$discount)
        {
            Session::flash('error' , 'El descuento no existe.');

            return Redirect::route('discounts.index');
        }

        $data = Input::all();

        $data['id'] = $id;


        $updateDiscount = new DiscountManager( $data );

        $response = $updateDiscount->update();

        if($response['success'])
        {
            Session::flash('success' , 'El descuento se ha actualizado correctamente.');

            return Redirect::route('discounts.index');
        }
        else
        {

            Session::flash('error' , 'Existen errores en el formulario.');

            return Redirect::back()->withErrors($response['errors'])->withInput();

        }
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
        $data = Input::all();

        $data['id'] = (int) $id;

        $discount = Discount::find($id);

        if(!$discount)
        {
            Session::flash('error' , 'El descuento especificado no existe.');

            return Redirect::route('discounts.index');
        }

        $deleteDiscount = new DiscountManager( $data );

        $response = $deleteDiscount->delete();

        if($response)
        {
            Session::flash('success' , 'El descuento se ha eliminado correctamente.');

            return Redirect::route('discounts.index');
        }
        else
        {

            Session::flash('error' , 'No ha sido posible eliminar el descuento.');

            return Redirect::back()->withErrors($response['errors'])->withInput();

        }
	}


    public function API( $method = 'all')
    {

        return $this->api->$method();

    }

}