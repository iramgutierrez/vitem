<?php

class Employee extends \Eloquent {

	protected $fillable = ['salary', 'employee_type_id' , 'users_id', 'entry_date'];

	public function User()
    {
        return $this->belongsTo('User', 'users_id' ,'id');
    }

}