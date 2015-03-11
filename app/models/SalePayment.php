<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class SalePayment extends \Eloquent {

    use SoftDeletingTrait;

	protected $fillable = [ 'sale_id' , 'employee_id' , 'user_id' , 'pay_type_id' ,'subtotal' , 'total' , 'commission_pay'];
    
    protected $appends = ['url_edit' ,  'url_delete', 'day' , 'week' , 'month'  ];

    
   
    public function employee()
    {
        return $this->belongsTo('Employee');
    }

    public function user()
    {
        return $this->belongsTo('User');
    }

    public function sale()
    {
        return $this->belongsTo('Sale');
    }

    public function getUrlEditAttribute()
    {
        return URL::route('sale_payments.edit', [$this->id]);
    }   

    public function getUrlDeleteAttribute()
    {
        return URL::route('sale_payments.destroy', [$this->id]);
    }

    public function getDayAttribute()
    {
        //Si la variable $fecha es null se le asigna valor
        $date = substr($this->created_at , 0 , 10);
        //Se explota la fecha
        $date = explode("-",$date);
        //Se obtiene la fecha en formato timestamp
        $unix = mktime(0,0,0,$date[1],$date[2],$date[0]);
        //Se devuelve el valor
         return date('Y-m-d', $unix);
    }

    public function getWeekAttribute()
    {
        //Si la variable $fecha es null se le asigna valor
        $date = substr($this->created_at , 0 , 10);
        //Se explota la fecha
        $date = explode("-",$date);
        //Se obtiene la fecha en formato timestamp
        $unix = mktime(0,0,0,$date[1],$date[2],$date[0]);
        //Se devuelve el valor
         return date('Y - W', $unix);
    }

    public function getMonthAttribute()
    {
        //Si la variable $fecha es null se le asigna valor
        $date = substr($this->created_at , 0 , 10);
        //Se explota la fecha
        $date = explode("-",$date);
        //Se obtiene la fecha en formato timestamp
        $unix = mktime(0,0,0,$date[1],$date[2],$date[0]);
        //Se devuelve el valor
         return date('Y - m', $unix);
    }

    public static function boot()
    {
        parent::boot();

        static::created(function($sale_payment)
        {
            Record::create([
                'user_id' => Auth::user()->id,
                'type' => 1,
                'entity' => 'SalePayment',
                'entity_id' => $sale_payment->id,
                'message' => 'agregó un abono con id '.$sale_payment->id.' a la venta con folio  '.$sale_payment->sale->sheet,
                'object' => $sale_payment->sale->toJson()

            ]);
        });

        static::updated(function($sale_payment)
        { 
            Record::create([
                'user_id' => Auth::user()->id,
                'type' => 3,
                'entity' => 'SalePayment',
                'entity_id' => $sale_payment->id,
                'message' => 'editó un abono con id '.$sale_payment->id.' a la venta con folio  '.$sale_payment->sale->sheet,
                'object' => $sale_payment->sale->toJson()
            ]);
        });        

        static::deleted(function($sale_payment)
        {
            
            Record::create([
                'user_id' => Auth::user()->id,
                'type' => 4,
                'entity' => 'SalePayment',
                'entity_id' => $sale_payment->id,
                'message' => 'eliminó un abono con id '.$sale_payment->id.' a la venta con folio  '.$sale_payment->sale->sheet,
                'object' => $sale_payment->sale->toJson()

            ]);
        });

    }

}