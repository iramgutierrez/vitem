<?php

use Vitem\Managers\CatalogItemManager;

class CatalogItemsController extends \BaseController {



	public function __construct()
	{

		
	}

	/**
	 * Display a listing of the resource.
	 * GET /paytypes
	 *
	 * @return Response
	 */
	public function index()
	{		


	}

	/**
	 * Show the form for creating a new resource.
	 * GET /paytypes/create
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /paytypes
	 *
	 * @return Response
	 */
	public function store()
	{
		
		$catalogItemData = Input::all();

        $createCatalogItem = new CatalogItemManager( $catalogItemData );

        if(!empty($catalogItemData['id']))
        {
            if(!empty($catalogItemData['delete']))
            {
                $response = $createCatalogItem->delete();

                $actionMessage = 'eliminado';
            }
            else
            {
                $response = $createCatalogItem->update();

                $actionMessage = 'actuaizado';
            }

        }
        else
        {
            $response = $createCatalogItem->save();

            $actionMessage = 'guardado';
        }


        if($response['success'])
        {
            Session::flash('success' , 'El elemento se ha '.$actionMessage.' correctamente.');

        }
        else
        {
            $message = 'Existen errores en el formulario.';

            foreach($response['errors'] as $field){
                foreach($field as $err)
                {
                    $message.='<br>'.$err;
                }
            }
            Session::flash('error' , $message);
        }

        return Redirect::back();

	}

	/**
	 * Display the specified resource.
	 * GET /paytypes/{id}
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
	 * GET /paytypes/{id}/edit
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
	 * PUT /paytypes/{id}
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
	 * DELETE /paytypes/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$catalogItem = CatalogItem::find($id);

		if(!$catalogItem)
		{
			Session::flash('error' , 'El elemento no existe.');

        	return Redirect::route('catalog_items.index');
		}

        CatalogItem::destroy($id);

	    Session::flash('success' , 'El elemento se ha eliminado correctamente.');

        return Redirect::route('catalog_items.index');
	}

	public function API( $method = 'all')
	{

		return $this->CatalogAPI->$method();

	}

}