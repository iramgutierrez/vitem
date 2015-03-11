<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Commission extends \Eloquent {

    use SoftDeletingTrait;

	protected $fillable = ['total' , 'sale_id' , 'type' , 'employee_id' , 'user_id' , 'total_commission' , 'percent'];

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

    public function sale_payments()
    {
        return $this->belongsToMany('SalePayment', 'commission_sale_payment');
    }

    public function getUrlEditAttribute()
    {
        return URL::route('commissions.edit', [$this->id]);
    }   

    public function getUrlDeleteAttribute()
    {
        return URL::route('commissions.destroy', [$this->id]);
    }

    public static function boot()
    {
        parent::boot();

        static::created(function($commision)
        {
            Record::create([
                'user_id' => Auth::user()->id,
                'type' => 1,
                'entity' => 'Commission',
                'entity_id' => $commision->id,
                'message' => 'agregó la comisión con id '.$commision->id,
                'object' => $commision->sale->toJson()

            ]);
        });

        static::updated(function($commision)
        {
            Record::create([
                'user_id' => Auth::user()->id,
                'type' => 3,
                'entity' => 'Commission',
                'entity_id' => $commision->id,
                'message' => 'editó la comisión con id '.$commision->id,
                'object' => $commision->sale->toJson()

            ]);
        });        

        static::deleted(function($commision)
        {
            Record::create([
                'user_id' => Auth::user()->id,
                'type' => 4,
                'entity' => 'Commission',
                'entity_id' => $commision->id,
                'message' => 'eliminó la comisión con id '.$commision->id,
                'object' => $commision->sale->toJson()

            ]);
        });

    }

}