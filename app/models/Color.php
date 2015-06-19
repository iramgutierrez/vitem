<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Color extends \Eloquent {

	use SoftDeletingTrait;

	protected $fillable = ['name' , 'slug', 'user_id'];

	protected $appends = [ 'url_delete' ];

    public function getUrlDeleteAttribute()
	{
	    return URL::route('colors.destroy', [$this->id]);
	}	

}