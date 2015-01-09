<?php

class Client extends \Eloquent {
	
	protected $fillable = [
			'name',
			'rfc',
			'business_name',
			'street',
			'outer_number',
			'inner_number',
			'zip_code',
			'colony',
			'city',
			'state',
			'phone' , 
			'email' , 
			'client_type_id', 
			'status' , 
			'image_profile',
			'entry_date'
			];
	
    protected $appends = ['url_show' , 'url_edit' ,  'url_delete' , 'image_profile_url' , 'week' ];

	public function ClientType()
    {
        return $this->belongsTo('ClientType');
    }

    public function getUrlShowAttribute()
	{
	    return URL::route('clients.show', [$this->id]);
	}

    public function getUrlEditAttribute()
	{
	    return URL::route('clients.edit', [$this->id]);
	}	

    public function getUrlDeleteAttribute()
	{
	    return URL::route('clients.destroy', [$this->id]);
	}

	public function getImageProfileUrlAttribute()
	{
		$image = ($this->image_profile) ?  $this->image_profile : 'default.jpg';
		return URL::asset('images_profile_clients/'. $image);
	}

	public function getWeekAttribute()
    {
        if($this->entry_date)
        {
            //Si la variable $fecha es null se le asigna valor
            $date = $this->entry_date;
            //Se explota la fecha
            $date = explode("-",$date);
            //Se obtiene la fecha en formato timestamp
            $unix = mktime(0,0,0,$date[1],$date[2],$date[0]);
            //Se devuelve el valor
            return date('W', $unix);
        
        }
    }

	public static function boot()
    {
        parent::boot();

        static::created(function($client)
        {
        	$client->ClientType; 
            Record::create([
				'user_id' => Auth::user()->id,
				'type' => 1,
				'entity' => 'Client',
				'entity_id' => $client->id,
				'message' => 'agregó el cliente '.$client->name,
				'object' => $client->toJson()

			]);
        });

        static::updated(function($client)
        {
        	$client->ClientType; 
            Record::create([
				'user_id' => Auth::user()->id,
				'type' => 3,
				'entity' => 'Client',
				'entity_id' => $client->id,
				'message' => 'editó el cliente '.$client->name,
				'object' => $client->toJson()

			]);
        });        

        static::deleted(function($client)
        {
        	$client->ClientType; 
            Record::create([
				'user_id' => Auth::user()->id,
				'type' => 4,
				'entity' => 'Client',
				'entity_id' => $client->id,
				'message' => 'eliminó el cliente '.$client->name,
				'object' => $client->toJson()

			]);
        });

    }
	

}