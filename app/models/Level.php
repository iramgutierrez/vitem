<?php

class Level extends \Eloquent {

	protected $fillable = ['description'];


	public function Role()
	{
		return $this->hasMany('Role');
	}

}