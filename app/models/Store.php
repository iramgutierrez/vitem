<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Store extends \Eloquent {

    use SoftDeletingTrait;

    protected $dates = ['deleted_at'];

	protected $fillable = ['name' , 'email' , 'address' , 'phone' , 'user_id'];

    protected $appends = ['url_show' , 'url_edit' ,  'url_delete' ];

    public function user()
    {
        return $this->belongsTo('User');
    }

    public function getUrlShowAttribute()
    {
        return URL::route('stores.show', [$this->id]);
    }

    public function getUrlEditAttribute()
    {
        return URL::route('stores.edit', [$this->id]);
    }   

    public function getUrlDeleteAttribute()
    {
        return URL::route('stores.destroy', [$this->id]);
    }   
}