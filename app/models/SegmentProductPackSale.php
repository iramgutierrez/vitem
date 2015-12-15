<?php


class SegmentProductPackSale extends \Eloquent {

	protected $table = 'segment_product_pack_sale';

    public function segment_product()
    {
        return $this->belongsTo('SegmentProduct');
    }

}