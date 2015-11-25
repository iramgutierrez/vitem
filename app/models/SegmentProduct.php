<?php


class SegmentProduct extends \Eloquent {
	
	protected $table = 'segment_product';

	protected $fillable = ['segment_id' , 'product_id', 'quantity'];

}