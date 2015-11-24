<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class CatalogItem extends \Eloquent {

	use SoftDeletingTrait;

	protected $fillable = ['name' , 'slug', 'user_id' , 'catalog_id'];

	protected $appends = [ 'url_delete' ];

    public function catalog()
    {
        return $this->belongsTo('Catalog');
    }

    public function getUrlDeleteAttribute()
	{
	    return URL::route('catalog_items.destroy', [$this->id]);
	}	

}