<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class PayType extends \Eloquent {

	use SoftDeletingTrait;

	protected $fillable = ['name' , 'percent_commission' , 'user_id'];

	protected $appends = [ 'url_delete' ];

    public function getUrlDeleteAttribute()
	{
	    return URL::route('pay_types.destroy', [$this->id]);
	}	

}