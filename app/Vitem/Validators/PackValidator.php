<?php namespace Vitem\Validators;

class PackValidator extends BaseValidator {
    
    protected $rules = array(
        'key'     => 'required|unique:packs,key',
        'name' => 'required|min:4|max:40',
        'description' => 'required',
        /*'price' => 'required',
        'cost' => 'required',
        'production_days' => 'required',*/
        'PackProduct' => 'required'
        /*'PackProduct.0.product_id' => 'required',
        'PackProduct.1.product_id' => 'required'*/
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