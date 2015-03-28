<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Employee extends \Eloquent {

	use SoftDeletingTrait;

	protected $dates = ['deleted_at'];

	protected $fillable = ['salary', 'employee_type_id' , 'users_id', 'entry_date'];

	public function User()
    {
        return $this->belongsTo('User', 'users_id' ,'id');
    }

	public function commissions()
	{
		return $this->hasMany('Commission');
	}

	public function deliveries()
	{
		return $this->hasMany('Delivery');
	}

	public function sales()
	{
		return $this->hasMany('Sale');
	}

	public function expenses()
	{
		return $this->hasMany('Expense');
	}

	public function sale_payments()
	{
		return $this->hasMany('SalePayment');
	}

}