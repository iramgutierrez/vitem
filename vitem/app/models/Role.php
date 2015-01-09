<?php

class Role extends \Eloquent {
	protected $fillable = [];

	public function User()
	{
		return $this->hasMany('User');
	}
}