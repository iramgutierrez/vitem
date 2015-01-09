<?php

class ClientType extends \Eloquent {

	protected $fillable = [];

	public function Client()
	{
		return $this->hasMany('Client');
	}
}