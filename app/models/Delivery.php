<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Delivery extends \Eloquent {

    use SoftDeletingTrait;

	protected $fillable = ['destination_id' , 'sale_id' , 'employee_id' , 'user_id' , 'address' , 'delivery_date' , 'pay_type_id' ,'subtotal' , 'total' , 'commission_pay' ];

	protected $appends = ['url_edit' ,  'url_delete' ];

	public function user()
    {
        return $this->belongsTo('User');
    }

    public function employee()
    {
        return $this->belongsTo('Employee');
    }

    public function sale()
    {
        return $this->belongsTo('Sale');
    }

    public function destination()
    {
        return $this->belongsTo('Destination');
    }

    public function pay_type()
    {
        return $this->belongsTo('PayType');
    }

    public function getUrlEditAttribute()
	{
	    return URL::route('deliveries.edit', [$this->id]);
	}	

    public function getUrlDeleteAttribute()
	{
	    return URL::route('deliveries.destroy', [$this->id]);
	}	

	public static function boot()
    {
        parent::boot();

        static::created(function($delivery)
        {
            Record::create([
                'user_id' => Auth::user()->id,
                'type' => 1,
                'entity' => 'Delivery',
                'entity_id' => $delivery->id,
                'message' => 'agregó la entrega con id '.$delivery->id,
                'object' => $delivery->sale->toJson()

            ]);
        });

        static::updated(function($delivery)
        {
            Record::create([
                'user_id' => Auth::user()->id,
                'type' => 3,
                'entity' => 'Delivery',
                'entity_id' => $delivery->id,
                'message' => 'editó la entrega con id '.$delivery->id,
                'object' => $delivery->sale->toJson()

            ]);
        });        

        static::deleted(function($delivery)
        {
            Record::create([
                'user_id' => Auth::user()->id,
                'type' => 4,
                'entity' => 'Delivery',
                'entity_id' => $delivery->id,
                'message' => 'eliminó la entrega con id '.$delivery->id,
                'object' => $delivery->sale->toJson()

            ]);
        });

    }


}