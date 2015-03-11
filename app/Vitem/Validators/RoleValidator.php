<?php namespace Vitem\Validators;

class RoleValidator extends BaseValidator {
    
    protected $rules = array(
        'name' => 'required|unique:roles,name',
        'level_id' => 'required'
    );

    /*public function __construct()
    {
        //$this->model = $model;

        return parent::__construct(new \User);
    }*/

    public function getUpdateRules()
    {
        $rules = $this->getRules();  

         if (isset ($rules['name']))
        { 
            // Si el usuario existe: Excluimos su ID de la regla "unique" (definida al final de la cadena)
            $rules['name'] .= ',' . $this->model->id;
        }

        $this->rules = $rules;      

        return $rules;
    }
    
    public function getCreateRules()
    {
    	$rules = $this->getRules();

        return $rules;
    }

    
    
}