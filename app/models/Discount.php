<?php
use Illuminate\Database\Eloquent\SoftDeletingTrait;


class Discount extends \Eloquent {

    use SoftDeletingTrait;

    protected $dates = ['deleted_at'];

	protected $fillable = ['type' , 'init_date','end_date' ,'discount_type' , 'quantity' , 'item_type' , 'item_id' , 'item_quantity' , 'user_id'];

    protected $appends = ['url_show' , 'url_edit' ,  'url_delete' ];

    public function getUrlShowAttribute()
    {
        return URL::route('discounts.show', [$this->id]);
    }

    public function getUrlEditAttribute()
    {
        return URL::route('discounts.edit', [$this->id]);
    }   

    public function getUrlDeleteAttribute()
    {
        return URL::route('discounts.destroy', [$this->id]);
    }

    public function stores()
    {
        return $this->belongsToMany('Store', 'discount_store');
    }

    public function pay_types()
    {
        return $this->belongsToMany('PayType', 'discount_pay_type');
    }

    public function item()
    {
        return $this->morphTo();
    }

}