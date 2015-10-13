<?php

//use Vitem\Repositories\PermissionRepo;

class Movement extends Eloquent {

	protected $fillable = ['user_id' , 'store_id' , 'type' , 'entity' , 'entity_id' , 'amount_in' , 'amount_out' , 'date'];

    protected $appends = [];

    public function User()
    {
        return $this->belongsTo('User', 'user_id' ,'id');
    }

}