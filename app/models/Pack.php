<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Pack extends \Eloquent {

	use SoftDeletingTrait;
	
	protected $fillable = ['name' , 'key' , 'description' , 'status' ,'image' , 'user_id' , 'price' , 'cost' , 'production_days'];

	protected $appends = ['url_show' , 'url_edit' ,  'url_delete' , 'image_url' ];

	public function products()
    {
        return $this->belongsToMany('Product', 'pack_product')->withPivot('quantity');
    }

        public function getUrlShowAttribute()
	{
	    return URL::route('packs.show', [$this->id]);
	}

    public function getUrlEditAttribute()
	{
	    return URL::route('packs.edit', [$this->id]);
	}	

    public function getUrlDeleteAttribute()
	{
	    return URL::route('packs.destroy', [$this->id]);
	}

	public function getImageUrlAttribute()
	{
		$image = ($this->image) ?  $this->image : 'default.jpg';
		return URL::asset('images_packs/'. $image);
	}

	public static function boot()
    {
        parent::boot();

        static::created(function($pack)
        {
        	Record::create([
				'user_id' => Auth::user()->id,
				'type' => 1,
				'entity' => 'Pack',
				'entity_id' => $pack->id,
				'message' => 'agregó el paquete '.$pack->name,
				'object' => $pack->toJson()

			]);
        });

        static::updated(function($pack)
        { 
            Record::create([
				'user_id' => Auth::user()->id,
				'type' => 3,
				'entity' => 'Pack',
				'entity_id' => $pack->id,
				'message' => 'editó el producto '.$pack->name,
				'object' => $pack->toJson()
			]);
        });        

        static::deleted(function($pack)
        {
        	
            Record::create([
				'user_id' => Auth::user()->id,
				'type' => 4,
				'entity' => 'Pack',
				'entity_id' => $pack->id,
				'message' => 'eliminó el paquete '.$pack->name,
				'object' => $pack->toJson()

			]);
        });

    }

}