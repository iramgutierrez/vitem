<?php
use Illuminate\Database\Eloquent\SoftDeletingTrait;


class Discount extends \Eloquent {

    use SoftDeletingTrait;

    protected $dates = ['deleted_at'];

	protected $fillable = ['name','type' , 'init_date','end_date' ,'discount_type' , 'quantity' , 'item_type' , 'item_id' , 'item_quantity' , 'user_id'];

    protected $appends = ['url_show' , 'url_edit' ,  'url_delete' , 'type_filter' ,'discount_type_filter' , 'quantity_filter' ,'item_type_filter' ];

    public function user()
    {
        return $this->belongsTo('User');
    }

    public function getTypeFilterAttribute()
    {
        $types = [
            '1' => 'Por producto/paquete',
            '2' => 'Por venta'
        ];

        return (isset($types[$this->type])) ? $types[$this->type]: '';
    }

    public function getDiscountTypeFilterAttribute()
    {
        $discount_types = [
            'percent' => 'Porcentaje',
            'quantity' => 'Cantidad'
        ];

        return (isset($discount_types[$this->discount_type])) ? $discount_types[$this->discount_type]: '';
    }

    public function getQuantityFilterAttribute()
    {

        if($this->discount_type == 'percent')
        {
            return $this->quantity.'%';
        }
        else if($this->discount_type == 'quantity')
        {
            return "$".number_format($this->quantity, 2);
        }

        return $this->quantity;
    }

    public function getItemTypeFilterAttribute()
    {

        if($this->item_type == 'Product')
        {
            return 'Producto';
        }
        else if($this->item_type == 'Pack')
        {
            return "Paquete";
        }

        return $this->item_type;

    }

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