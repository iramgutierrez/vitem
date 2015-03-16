<?php namespace Vitem\Validators;

class ProductValidator extends BaseValidator {
    
    protected $rules = array(
        'key'     => 'required|unique:products,key',
        'name' => 'required|min:4|max:40',
        'model' => 'required',
        /*'description' => 'required',
        'stock' => 'required',
        'price' => 'required',*/
        'cost' => 'required',
        //'production_days' => 'required',
        'supplier_id' => 'required|exists:suppliers,id',
        'user_id' => 'required',
        'image'  => 'max:500',
    );

    /*public function __construct()
    {
        //$this->model = $model;

        return parent::__construct(new \User);
    }*/

    public function getUpdateRules()
    {
        $rules = $this->getRules();

        if (isset ($rules['key']))
        {
            $rules['key'] .= ',' . $this->model->id;
        }
        return $rules;
    }
    
    public function getCreateRules()
    {
    	$rules = $this->getRules();

        return $rules;
    }

    

    
    
}