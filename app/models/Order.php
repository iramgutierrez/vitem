<?php
use Illuminate\Database\Eloquent\SoftDeletingTrait;


class Order extends \Eloquent { 

    use SoftDeletingTrait;

    protected $dates = ['deleted_at'];

	protected $fillable = ['order_date' , 'supplier_id' , 'user_id' , 'total'];

    protected $appends = ['url_show' , 'url_edit' ,  'url_delete' ];

	public function products()
    {
        return $this->belongsToMany('Product', 'order_product')->withPivot(['quantity' , 'status']);
    }

    public function user()
    {
        return $this->belongsTo('User');
    }

    public function supplier()
    {
        return $this->belongsTo('Supplier');
    }

    public function getUrlShowAttribute()
    {
        return URL::route('orders.show', [$this->id]);
    }

    public function getUrlEditAttribute()
    {
        return URL::route('orders.edit', [$this->id]);
    }   

    public function getUrlDeleteAttribute()
    {
        return URL::route('orders.destroy', [$this->id]);
    }   

}