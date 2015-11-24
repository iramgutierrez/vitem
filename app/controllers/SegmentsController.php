<?php

use Vitem\Managers\SegmentManager;
use Vitem\WebServices\SegmentWebServices as SegmentAPI;

class SegmentsController extends \BaseController {

	protected $SegmentAPI;

	public function __construct(SegmentAPI $SegmentAPI)
	{
		$this->SegmentAPI = $SegmentAPI;

		$this->beforeFilter('ACL:Segment,Read', ['only' => [ 'index' , 'show' ] ]);

		$this->beforeFilter('ACL:Segment,Read,true', ['only' => [ 'API'] ]);

		$this->beforeFilter('ACL:Segment,Create', ['only' => [ 'create' , 'store' ] ]);

		$this->beforeFilter('ACL:Segment,Update', [ 'only' => [ 'edit' , 'update' ] ]);

		$this->beforeFilter('ACL:Segment,Delete', [ 'only' => 'destroy' ] );
		
	}

	/**
	 * Display a listing of the resource.
	 * GET /paytypes
	 *
	 * @return Response
	 */
	public function index()
	{		

		return View::make('segments/index');
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
		
		$segmentData = Input::all();  

		$createSegment = new SegmentManager( $segmentData );

        $response = $createSegment->save();

        return Response::json($response , 200);

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
		$segment = Segment::find($id);

		if(!$segment)
		{
			Session::flash('error' , 'El criterio de segmentación no existe.');

        	return Redirect::route('segments.index');
		}

		Segment::destroy($id);

	    Session::flash('success' , 'El criterio de segmentación se ha eliminado correctamente.');

        return Redirect::route('segments.index');
	}

	public function API( $method = 'all')
	{

		return $this->SegmentAPI->$method();

	}

}