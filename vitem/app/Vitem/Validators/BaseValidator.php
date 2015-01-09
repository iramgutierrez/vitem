<?php namespace Vitem\Validators;

abstract class BaseValidator
{

    protected $rules;

    protected $model;
    protected $errors;
    
    public function __construct(\Eloquent $model)
    {
        $this->model = $model;
    }
    
    public function getRules()
    {
        return $this->rules;
    }
        
    public function getCreateRules()
    {
        return $this->getRules();
    }
    
    public function getUpdateRules()
    {
        return $this->getRules();
    }
    
    public function getErrors()
    {
        return $this->errors;
    }

    public function isValid($data)
    { 
        if ($this->model->exists)
        {
            $this->rules = $this->getUpdateRules();
        }
        else
        {
            $this->rules = $this->getCreateRules();
        }

        $rules = $this-> getRules();
        
        $validation = \Validator::make($data, $rules);

        if ($validation->passes()) return true;

        $this->errors = $validation->messages();

        return false;
    }

}