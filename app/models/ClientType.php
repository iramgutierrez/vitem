<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class ClientType extends \Eloquent {

	use SoftDeletingTrait;

	protected $fillable = ['name' , 'slug' ,'user_id'];

	protected $appends = [ 'url_delete' ];

    public function getUrlDeleteAttribute()
	{
	    return URL::route('client_types.destroy', [$this->id]);
	}	

	public function Client()
	{
		return $this->hasMany('Client');
	}
}