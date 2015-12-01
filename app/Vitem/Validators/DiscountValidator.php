<?php namespace Vitem\Validators;

class DiscountValidator extends BaseValidator {

    protected $rules = array(
        'name'     => 'required',
        'type'     => 'required',
        'init_date'     => 'required',
        'end_date'     => 'required',
        'discount_type'     => 'required',
        'quantity'     => 'required',
        'user_id' => 'required|exists:users,id',
        'DiscountStore' => 'required|min:1',
        'DiscountPayType' => 'required|min:1'
    );

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