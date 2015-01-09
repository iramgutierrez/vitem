<?php

class Employee extends \Eloquent {
	protected $fillable = [];

	public function user()
    {
        return $this->hasOne('Vitem\Entities\User', 'id', 'id');
    }
}