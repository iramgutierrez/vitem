<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Destination extends \Eloquent {

	use SoftDeletingTrait;


	protected $fillable = ['cost' , 'type' , 'zip_code' , 'colony' , 'town' , 'state' ];

	protected $appends = ['url_show' , 'url_edit' ,  'url_delete' , 'value_type' ];

	public function User()
    {
        return $this->belongsTo('User', 'user_id' ,'id');
    }

    public function getUrlShowAttribute()
	{
	    return URL::route('destinations.show', [$this->id]);
	}

    public function getUrlEditAttribute()
	{
	    return URL::route('destinations.edit', [$this->id]);
	}	

    public function getUrlDeleteAttribute()
	{
	    return URL::route('destinations.destroy', [$this->id]);
	}	

    public function getValueTypeAttribute()
	{

		$value = '';

	    switch($this->type)
	    {
	    
	    	case 1:
	    		$value = $this->zip_code;
	    		break;
	    	case 2:
	    		$value = $this->colony;
	    		break;
	    	case 3:
	    		$value = $this->town;
	    		break;
	    	case 4:
	    		$value = $this->state;
	    		break;
	    }


	    return $value;
	}

	public static function boot()
    {
        parent::boot();

        static::created(function($destination)
        {
            Record::create([
				'user_id' => Auth::user()->id,
				'type' => 1,
				'entity' => 'Destination',
				'entity_id' => $destination->id,
				'message' => 'agregó el destino con id '.$destination->id,
				'object' => $destination->toJson()

			]);
        });

        static::updated(function($destination)
        {
            Record::create([
				'user_id' => Auth::user()->id,
				'type' => 3,
				'entity' => 'Destination',
				'entity_id' => $destination->id,
				'message' => 'editó el destino con id '.$destination->id,
				'object' => $destination->toJson()

			]);
        });        

        static::deleted(function($destination)
        {
            Record::create([
				'user_id' => Auth::user()->id,
				'type' => 4,
				'entity' => 'Destination',
				'entity_id' => $destination->id,
				'message' => 'eliminó el destino con id '.$destination->id,
				'object' => $destination->toJson()

			]);
        });

    }


}