<?php

class Role extends \Eloquent {

	protected $fillable = ['name' , 'slug' , 'level_id'];
	
    protected $appends = ['url_show' , 'url_edit' ,  'url_delete' ];


	public function User()
	{
		return $this->hasMany('User');
	}

	public function Permission()
	{
		return $this->hasMany('Permission');
	}

	public function Level()
	{
		return $this->belonsgTo('Level');
	}

    public function getUrlShowAttribute()
	{
	    return URL::route('roles.show', [$this->id]);
	}

    public function getUrlEditAttribute()
	{
	    return URL::route('roles.edit', [$this->id]);
	}	

    public function getUrlDeleteAttribute()
	{
	    return URL::route('roles.destroy', [$this->id]);
	}

}