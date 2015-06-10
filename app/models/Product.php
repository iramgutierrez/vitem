<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Product extends \Eloquent {

	use SoftDeletingTrait;

	protected $fillable = ['key' , 'name' , 'stock' , 'model' , 'description' , 'supplier_id' , 'image' , 'price' , 'cost' , 'production_days' , 'user_id' , 'status' ];

	 protected $appends = ['url_show' , 'url_edit' ,  'url_delete' , 'image_url' , 'stock_in_stores'];

	public function Supplier()
    {
        return $this->hasOne('Supplier', 'id', 'supplier_id');
    }

    public function User()
    {
        return $this->hasOne('User', 'id', 'user_id');
    }

    public function packs()
    {
        return $this->belongsToMany('Pack', 'pack_product');
    }

	public function sales()
	{
		return $this->belongsToMany('Sale', 'product_sale')->withPivot('quantity');
	}

	public function stores()
	{
		return $this->belongsToMany('Store', 'product_store')->withPivot('quantity');
	}

    public function getUrlShowAttribute()
	{
	    return URL::route('products.show', [$this->id]);
	}

    public function getUrlEditAttribute()
	{
	    return URL::route('products.edit', [$this->id]);
	}	

    public function getUrlDeleteAttribute()
	{
	    return URL::route('products.destroy', [$this->id]);
	}

	public function getImageUrlAttribute()
	{
		$image = ($this->image) ?  $this->image : 'default.jpg';
		return URL::asset('images_products/'. $image);
	}

	public function getStockInStoresAttribute()
	{
		$stores = $this->stores;

		$stocks = [];

		foreach($stores as $k => $store)
		{
			$stocks[$store->id] = $store->pivot->quantity;
		}

		return $stocks;
	}

	public static function boot()
    {
        parent::boot();

        static::created(function($product)
        {
        	$product->Supplier; 
        	$product->User;
            Record::create([
				'user_id' => Auth::user()->id,
				'type' => 1,
				'entity' => 'Product',
				'entity_id' => $product->id,
				'message' => 'agregó el producto '.$product->name,
				'object' => $product->toJson()

			]);
        });

        static::updated(function($product)
        { 
        	$product->Supplier; 
        	$product->User;
            Record::create([
				'user_id' => Auth::user()->id,
				'type' => 3,
				'entity' => 'Product',
				'entity_id' => $product->id,
				'message' => 'editó el producto '.$product->name,
				'object' => $product->toJson()
			]);
        });        

        static::deleted(function($product)
        {
        	$product->Supplier; 
        	$product->User;
            Record::create([
				'user_id' => Auth::user()->id,
				'type' => 4,
				'entity' => 'Product',
				'entity_id' => $product->id,
				'message' => 'eliminó el producto '.$product->name,
				'object' => $product->toJson()

			]);
        });

    }
}