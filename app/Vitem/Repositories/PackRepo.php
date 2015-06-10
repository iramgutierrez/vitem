<?php namespace Vitem\Repositories;

use Vitem\Repositories\PermissionRepo;

class PackRepo extends BaseRepo {

	protected static $packs;

	public function getModel()
	{
		return new \Pack;
	}

	static function all(){

		return \Store::all();
		
	}

	static function find2($id){

		return ($id);
		
	}

	static function getProducts($packId)
	{
		if(!PermissionRepo::checkAuth('Product' , 'Read') )
		{
			return [];
		}
		
		$pack = \Pack::where('id' , $packId)->first();

		if(!$pack)
			return false;

		return $pack->products;
	}

	static function with($entities )
	{

		return \Pack::with(parent::with($entities));


	}

	static function getByKeyAndStore( $key , $store_id)
	{
		$pack = \Pack::with('products')->where('key' , $key);

		/*$pack = $pack->whereIn('id', function ($query) use ($store_id) {

				$query->select(\DB::raw('product_id'))
						->from('product_store')
						->where('store_id' , $store_id)
						->where('product_store.quantity' , '>' , 0);

			});*/

		$pack = $pack->first();

		return $pack;
	}

	private static function generateLikeCondition( $sentence , $fields )
	{

		if($sentence != ''){

			self::$packs->where(
							function($query) use ($sentence , $fields) {
								
								foreach($fields as $field){

									$query->orWhere($field, 'LIKE' , '%' . $sentence . '%' );

								}

							}
							
						);

		}

	}

	public function search($find , $store_id)
	{

		self::$packs = \Pack::with('products');

		self::generateLikeCondition( $find , ['id' , 'name' , 'key' ]);

		/*self::$packs->whereIn('id', function ($query) use ($store_id) {

				$query->select(\DB::raw('product_id'))
						->from('product_store')
						->where('store_id' , $store_id)
						->where('product_store.quantity' , '>' , 0);

			});*/

		return self::$packs->get();

	}


}