<?php namespace Vitem\Validators;

class ProductValidator extends BaseValidator {
    
    protected $rules = array(
        'key'     => 'required|unique:products,id',
        'name' => 'required|min:4|max:40',
        'model' => 'required',
        'description' => 'required',
        'stock' => 'required',
        'price' => 'required',
        'cost' => 'required',
        'production_days' => 'required',
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
            // Si el usuario existe: Excluimos su ID de la regla "unique" (definida al final de la cadena)
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