<?php namespace Vitem\Validators;

class ExpenseValidator extends BaseValidator {
    
    protected $rules = array(
        'expense_type_id' => 'required|exists:expense_types,id',
        'user_id' => 'required|exists:users,id',
        'employee_id' => 'required|exists:employees,id',
        'quantity' => 'required',
        'date' => 'required'
    );

    /*public function __construct()
    {
        //$this->model = $model;

        return parent::__construct(new \User);
    }*/

    public function getUpdateRules()
    {
        $rules = $this->getRules();        

        return $rules;
    }
    
    public function getCreateRules()
    {
    	$rules = $this->getRules();

        return $rules;
    }

    
    
}