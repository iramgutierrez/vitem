<?php

class Supplier extends \Eloquent {

	protected $fillable = [
			'name' ,
			'rfc',
			'business_name',
			'street',
			'outer_number',
			'inner_number',
			'zip_code',
			'colony',
			'city',
			'state' , 
			'phone' , 
			'email' , 
			'status'
			];
	
    protected $appends = ['url_show' , 'url_edit' ,  'url_delete'  ];


    public function getUrlShowAttribute()
	{
	    return URL::route('suppliers.show', [$this->id]);
	}

    public function getUrlEditAttribute()
	{
	    return URL::route('suppliers.edit', [$this->id]);
	}	

    public function getUrlDeleteAttribute()
	{
	    return URL::route('suppliers.destroy', [$this->id]);
	}

	public static function boot()
    {
        parent::boot();

        static::created(function($supplier)
        {
            Record::create([
				'user_id' => Auth::user()->id,
				'type' => 1,
				'entity' => 'Supplier',
				'entity_id' => $supplier->id,
				'message' => 'agregó el proveedor '.$supplier->name,
				'object' => $supplier->toJson()

			]);
        });

        static::updated(function($supplier)
        {
            Record::create([
				'user_id' => Auth::user()->id,
				'type' => 3,
				'entity' => 'Supplier',
				'entity_id' => $supplier->id,
				'message' => 'editó el proveedor '.$supplier->name,
				'object' => $supplier->toJson()

			]);
        });        

        static::deleted(function($supplier)
        {
            Record::create([
				'user_id' => Auth::user()->id,
				'type' => 4,
				'entity' => 'Supplier',
				'entity_id' => $supplier->id,
				'message' => 'eliminó el proveedor '.$supplier->name,
				'object' => $supplier->toJson()

			]);
        });

    }

    /*
	ALTER TABLE `users` ADD `street` VARCHAR(255) NOT NULL AFTER `address`, ADD `outer_number` VARCHAR(255) NOT NULL AFTER `street`, ADD `inner_number` VARCHAR(255) NOT NULL AFTER `outer_number`, ADD `postal_code` VARCHAR(255) NOT NULL AFTER `inner_numbe`, ADD `colony` VARCHAR(255) NOT NULL AFTER `postal_code`, ADD `city` VARCHAR(255) NOT NULL AFTER `colony`, ADD `state` VARCHAR(255) NOT NULL AFTER `city`;

    */
}