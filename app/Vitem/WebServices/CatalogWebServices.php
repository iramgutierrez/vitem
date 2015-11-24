<?php namespace Vitem\WebServices;


class CatalogWebServices extends BaseWebServices {

	public function all()
	{

		return \Response::json(\Catalog::with('items')->where('slug' ,'!=', 'not-assigned')->get());

	}

    public function getNotAssignedId()
    {
        return \Catalog::with('items')->where('slug' , 'not-assigned')->first();
    }
}