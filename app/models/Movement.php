<?php

//use Vitem\Repositories\PermissionRepo;

class Movement extends Eloquent {

	protected $fillable = ['user_id' , 'store_id' , 'type' , 'entity' , 'entity_id' , 'amount_in' , 'amount_out' , 'total' , 'date'];

    protected $appends = [];

    public function user()
    {
        return $this->belongsTo('User', 'user_id' ,'id');
    }

    public function store()
    {
        return $this->belongsTo('Store', 'store_id' ,'id');
    }

    public static function create(array $attributes)
    {
        if(isset($attributes['amount_in']) && isset($attributes['amount_out']))
        {
            $attributes['total'] = $attributes['amount_in'] - $attributes['amount_out'];
        }

        return parent::create($attributes);
    }

}