<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Segment extends \Eloquent {

	use SoftDeletingTrait;

	protected $fillable = ['name' , 'slug', 'user_id'];

	protected $appends = [ 'url_delete' ];

    public function catalog_items()
    {
        return $this->belongsToMany('CatalogItem', 'segment_catalog_item');
    }

    public function getUrlDeleteAttribute()
	{
	    return URL::route('segments.destroy', [$this->id]);
	}	

}