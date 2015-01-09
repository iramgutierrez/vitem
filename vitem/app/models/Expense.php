<?php

class Expense extends \Eloquent {

	protected $fillable = ['expense_type_id' , 'user_id' , 'employee_id' , 'date' , 'concept' , 'description' , 'quantity'];

	protected $appends = ['url_show' , 'url_edit' ,  'url_delete'  ];

	public function User()
    {
        return $this->belongsTo('User', 'user_id' ,'id');
    }

    public function Employee()
    {
        return $this->belongsTo('Employee', 'employee_id' ,'id');
    }

    public function expense_type()
    {
        return $this->belongsTo('ExpenseType', 'expense_type_id' ,'id');
    }

    public function getUrlShowAttribute()
	{
	    return URL::route('expenses.show', [$this->id]);
	}

    public function getUrlEditAttribute()
	{
	    return URL::route('expenses.edit', [$this->id]);
	}	

    public function getUrlDeleteAttribute()
	{
	    return URL::route('expenses.destroy', [$this->id]);
	}	
    

	public static function boot()
    {
        parent::boot();

        static::created(function($expense)
        {
            Record::create([
				'user_id' => Auth::user()->id,
				'type' => 1,
				'entity' => 'Expense',
				'entity_id' => $expense->id,
				'message' => 'agregó el gasto con id '.$expense->id,
				'object' => $expense->toJson()

			]);
        });

        static::updated(function($expense)
        {
            Record::create([
				'user_id' => Auth::user()->id,
				'type' => 3,
				'entity' => 'Expense',
				'entity_id' => $expense->id,
				'message' => 'editó el gasto con id '.$expense->id,
				'object' => $expense->toJson()

			]);
        });        

        static::deleted(function($expense)
        {
            Record::create([
				'user_id' => Auth::user()->id,
				'type' => 4,
				'entity' => 'Expense',
				'entity_id' => $expense->id,
				'message' => 'eliminó el gasto con id '.$expense->id,
				'object' => $expense->toJson()

			]);
        });

    }



}