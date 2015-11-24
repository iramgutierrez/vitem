<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Catalog extends \Eloquent {

	use SoftDeletingTrait;

	protected $fillable = ['name' , 'slug', 'user_id'];

	protected $appends = [ 'url_delete' ];

    public function items()
    {
        return $this->hasMany('CatalogItem');
    }

    public function getUrlDeleteAttribute()
	{
	    return URL::route('catalogs.destroy', [$this->id]);
	}	

}