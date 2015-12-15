<?php


class PackSale extends \Eloquent {

    protected $table = 'pack_sale';

    protected $fillable = ['pack_id' , 'sale_id', 'quantity'];

    protected $appends = ['segments'];

    public function segments_products()
    {
        return $this->belongsToMany('SegmentProduct', 'segment_product_pack_sale')->withPivot('quantity');
    }

}