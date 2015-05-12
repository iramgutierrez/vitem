<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class ExpenseType extends \Eloquent {

	use SoftDeletingTrait;

	protected $fillable = ['name' , 'slug' ,'user_id'];

	protected $appends = [ 'url_delete' ];

    public function getUrlDeleteAttribute()
	{
	    return URL::route('expense_types.destroy', [$this->id]);
	}	

}