<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class ColorProduct extends \Eloquent {

	use SoftDeletingTrait;
	
	protected $table = 'color_product';

	protected $fillable = ['color_id' , 'product_id', 'quantity'];

}