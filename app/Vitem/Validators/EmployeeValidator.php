<?php namespace Vitem\Validators;

class EmployeeValidator extends BaseValidator {
    
    protected $rules = array(
    );

    public function __construct()
    {
        //$this->model = $model;

        return parent::__construct(new \User);
    }

    public function getRulesForUpdate()
    {
       
    }
    
    public function getRulesForCreate()
    {
    	
    }
    
}