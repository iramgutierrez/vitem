<?php

class Action extends \Eloquent {

	protected $fillable = [];
	
    protected $appends = ['spanish_name'];

    public function getSpanishNameAttribute()
	{

		if (\Lang::has('messages.' . $this->slug))
        {
            $label = \Lang::get('messages.' . $this->slug);

            return ucfirst($label);
        }

	    return $this->slug;
	}	
}