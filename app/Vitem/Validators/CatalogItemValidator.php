<?php namespace Vitem\Validators;

class CatalogItemValidator extends BaseValidator {
    
    protected $rules = array(
        'name' => 'required',
        'slug' => 'required|unique_with:catalog_items,catalog_id',
        'catalog_id' => 'required|exists:catalogs,id'
    );

    /*public function __construct()
    {
        //$this->model = $model;

        return parent::__construct(new \User);
    }*/

    public function getUpdateRules()
    {
        $rules = $this->getRules();        

        if(isset($rules['slug']))
        {
            $rules['slug'].= ',' . $this->model->id;
        }

        return $rules;
    }
    
    public function getCreateRules()
    {
    	$rules = $this->getRules();

        return $rules;
    }

    
    
}