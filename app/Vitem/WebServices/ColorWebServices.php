<?php namespace Vitem\WebServices;

//use Vitem\Repositories\PackRepo;


class ColorWebServices extends BaseWebServices {

	public function all()
	{

		return \Response::json(\Color::where('slug' ,'!=', 'not-assigned')->get());

	}

    public function getNotAssignedId()
    {
        return \Color::where('slug' , 'not-assigned')->first();
    }
}