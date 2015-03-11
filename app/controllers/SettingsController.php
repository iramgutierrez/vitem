<?php

use Vitem\Managers\SettingManager;
use Vitem\WebServices\SettingWebServices as SettingAPI;

class SettingsController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /settings
	 *
	 * @return Response
	 */
	public function index()
	{		

		$settings = Setting::lists('value' , 'key');

		//echo "<pre>"; dd($settings);

		return View::make('settings/create' , compact('settings') );
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /settings/create
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('settings/create' );
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /settings
	 *
	 * @return Response
	 */
	public function store()
	{
		$data = Input::all(); 

		$createSettings = new SettingManager( $data );		

        $response = $createSettings->saveAll();

        if(isset($response['1'])){

			if($response['1'] > 1)
			{
				$success_message = 'Se guardaron correctamente ' . $response['1'] . ' configuraciones.';
			}
			else
			{
				$success_message = 'Se guardo correctamente ' . $response['1'] . ' configuraciones.';
			}

			Session::flash('success' , $success_message );
			
		}

		if(isset($response['0'] ) ){

			if($response['0'] > 1)
			{
				$error_message = 'Error al intentar guardar ' . $response['0'] . ' configuraciones.';
			}
			else
			{
				$error_message = 'Error al intentar guardar ' . $response['0'] . ' configuraciones.';
			}

			Session::flash('error' , $error_message);

		}

		return Redirect::route('settings.index');
        
	}

	/**
	 * Display the specified resource.
	 * GET /settings/{id}
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
	 * GET /settings/{id}/edit
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
	 * PUT /settings/{id}
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
	 * DELETE /settings/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

	public function API( $method = 'all')
	{

		return SettingAPI::{$method}();

	}

}