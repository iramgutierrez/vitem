<?php

use Vitem\Repositories\SaleRepo;

class Sale extends \Eloquent {

	protected $fillable = ['sheet' , 'total' ,'subtotal' ,'commission_pay' , 'sale_date' , 'sale_type' , 'pay_type_id' , 'liquidation_date' , 'client_id' , 'employee_id' , 'user_id' ,'store_id' , 'delivery_tab'];
    
    protected $appends = ['url_show' , 'url_edit' ,  'url_delete' , 'remaining_payment' , 'percent_cleared_payment','cleared_payment' , 'week' , 'month' ];

	public function products()
    {
        return $this->belongsToMany('Product', 'product_sale')->withPivot('quantity' , 'discount_id' , 'real_price' , 'discount_price');
    }

    public function segments_products()
    {
        return $this->belongsToMany('SegmentProduct', 'segment_product_sale')->withPivot('quantity');
    }

    public function packs()
    {
        return $this->belongsToMany('Pack', 'pack_sale')->withPivot('id','quantity' , 'discount_id' , 'real_price' , 'discount_price');
    }

    public function user()
    {
        return $this->belongsTo('User');
    }

    public function store()
    {
        return $this->belongsTo('Store');
    }

    public function pay_type()
    {
        return $this->belongsTo('PayType');
    }

    public function employee()
    {
        return $this->belongsTo('Employee');
    }

    public function client()
    {
        return $this->belongsTo('Client');
    }

     public function sale_payments()
    {
        return $this->hasMany('SalePayment');
    }

    public function commissions()
    {
        return $this->hasMany('Commission');
    }

    public function delivery()
    {
        return $this->hasOne('Delivery');
    }

    public function getUrlShowAttribute()
    {
        return URL::route('sales.show', [$this->id]);
    }

    public function getWeekAttribute()
    {
        if($this->sale_date)
        {
            //Si la variable $fecha es null se le asigna valor
            $date = $this->sale_date;
            //Se explota la fecha
            $date = explode("-",$date);
            //Se obtiene la fecha en formato timestamp
            $unix = mktime(0,0,0,$date[1],$date[2],$date[0]);
            //Se devuelve el valor
            return date('Y - W', $unix);
        
        }
    }

    public function getMonthAttribute()
    {
        if($this->sale_date)
        {//Si la variable $fecha es null se le asigna valor
        
            $date = $this->sale_date;
            //Se explota la fecha
            $date = explode("-",$date);
            //Se obtiene la fecha en formato timestamp
            $unix = mktime(0,0,0,$date[1],$date[2],$date[0]);
            //Se devuelve el valor
            return date('Y - m', $unix);

        }
    }

    public function getUrlEditAttribute()
    {
        return URL::route('sales.edit', [$this->id]);
    }   

    public function getUrlDeleteAttribute()
    {
        return URL::route('sales.destroy', [$this->id]);
    }

    public function getRemainingPaymentAttribute()
    {
        return SaleRepo::getRemainingPayment($this);
    }
    
    public function getPercentClearedPaymentAttribute()
    {
        return SaleRepo::getPercentClearedPayment($this);
    }
    
    public function getClearedPaymentAttribute()
    {
        return SaleRepo::getClearedPayment($this);
    }
    

    public static function boot()
    {
        parent::boot();

        static::created(function($sale)
        {
            Record::create([
                'user_id' => Auth::user()->id,
                'type' => 1,
                'entity' => 'Sale',
                'entity_id' => $sale->id,
                'message' => 'agregó la venta con folio  '.$sale->sheet,
                'object' => $sale->toJson()

            ]);
        });

        static::updated(function($sale)
        { 
            Record::create([
                'user_id' => Auth::user()->id,
                'type' => 3,
                'entity' => 'Sale',
                'entity_id' => $sale->id,
                'message' => 'editó la venta con folio '.$sale->sheet,
                'object' => $sale->toJson()
            ]);
        });        

        static::deleted(function($sale)
        {
            
            Record::create([
                'user_id' => Auth::user()->id,
                'type' => 4,
                'entity' => 'Sale',
                'entity_id' => $sale->id,
                'message' => 'eliminó la venta con folio '.$sale->sheet,
                'object' => $sale->toJson()

            ]);
        });

    }

    static function getAuth()
    {

        //return parent::get();

    }



}