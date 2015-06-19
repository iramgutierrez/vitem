<?php namespace Vitem\WebServices;

//use Vitem\Repositories\PackRepo;


class ColorWebServices extends BaseWebServices {

	public function all()
	{

		return \Response::json(\Color::all());

	}
}