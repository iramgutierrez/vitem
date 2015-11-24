<?php namespace Vitem\WebServices;


class SegmentWebServices extends BaseWebServices {

	public function all()
	{

		return \Response::json(\Segment::with('catalog_items.catalog.items')->where('slug' ,'!=', 'not-assigned')->get());

	}

    public function getNotAssignedId()
    {
        return \Segment::with('catalog_items.catalog.items')->where('slug' , 'not-assigned')->first();
    }
}