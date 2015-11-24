<?php namespace Vitem\Repositories;

class DiscountRepo extends BaseRepo {

	/*public function getModel()
	{
		return new Store;
	}*/

	protected static $discounts;

	public function getModel()
    {
        return new Discount;
    }

	static function all(){

		return \Discount::all();

	}

	static function findByPage($page , $perPage , $find , $type , $initDate , $endDate , $discountType, $store , $payType)
	{

		$offset = ($page - 1 ) * $perPage;

        self::$discounts = \Discount::with([
            'user',
            'item',
            'stores',
            'pay_types'
        ]);

		self::generateLikeCondition( $find , ['id']);

        self::generateTypeCondition( $type);

        self::generateInitDateCondition( $initDate);

        self::generateEndDateCondition( $endDate);

        self::generateDiscountTypeCondition( $discountType);

        self::generateStoreCondition( $store);

        self::generatePayTypeCondition( $payType);

		$whereUserId = \ACLFilter::generateAuthCondition();

		if(count($whereUserId))
			self::$discounts->whereIn( 'user_id' , $whereUserId);

		self::paginate($offset , $perPage);

		return self::$discounts->get();

	}

	static function countFind($find , $type , $initDate , $endDate , $discountType, $store , $payType)
	{

        self::$discounts = \Discount::with([
            'user',
            'item',
            'stores',
            'pay_types'
        ]);

		self::generateLikeCondition( $find , ['id']);

        self::generateTypeCondition( $type);

        self::generateInitDateCondition( $initDate);

        self::generateEndDateCondition( $endDate);

        self::generateDiscountTypeCondition( $discountType);

        self::generateStoreCondition( $store);

        self::generatePayTypeCondition( $payType);

		$whereUserId = \ACLFilter::generateAuthCondition();

		if(count($whereUserId))
			self::$discounts->whereIn( 'user_id' , $whereUserId);

		return self::$discounts->count();

	}



	private static function generateLikeCondition( $sentence , $fields )
	{

		if($sentence != ''){

			self::$discounts->where(
							function($query) use ($sentence , $fields) {

								foreach($fields as $field){

									$query->orWhere($field, 'LIKE' , '%' . $sentence . '%' );

								}

                                $query->orWhereIn('item_id' ,function($query) use ($sentence)
                                {
                                    $query->select(\DB::raw('id'))
                                        ->from('products')
                                        ->whereRaw('products.name LIKE "%' . $sentence . '%"');
                                });

                                $query->orWhereIn('item_id' ,function($query) use ($sentence)
                                {
                                    $query->select(\DB::raw('id'))
                                        ->from('packs')
                                        ->whereRaw('packs.name LIKE "%' . $sentence . '%"');
                                });

							}

						);

		}

	}

    private static function generateTypeCondition( $type)
    {

        if( $type){

            self::$discounts
                ->where( 'type',$type );

        }

    }

    private static function generateInitDateCondition( $initDate)
    {

        if( $initDate){

            self::$discounts
                ->where( 'init_date' , '>=',$initDate );

        }

    }

    private static function generateEndDateCondition( $endDate)
    {

        if( $endDate){

            self::$discounts
                ->where( 'end_date' , '<=',$endDate );

        }

    }

    private static function generateDiscountTypeCondition( $discountType)
    {

        if( $discountType){

            self::$discounts
                ->where( 'discount_type',$discountType );

        }

    }

    private static function generateStoreCondition($store)
    {
        if($store)
        {
            self::$discounts
                ->whereIn('id' , function($query) use ($store){
                    $query->select(\DB::raw('discount_id'))
                        ->from('discount_store')
                        ->whereRaw('discount_store.store_id = ' . $store );
                });
        }
    }

    private static function generatePayTypeCondition($payType)
    {
        if($payType)
        {
            self::$discounts
                ->whereIn('id' , function($query) use ($payType){
                    $query->select(\DB::raw('discount_id'))
                        ->from('discount_pay_type')
                        ->whereRaw('discount_pay_type.pay_type_id = ' . $payType );
                });
        }
    }

	private static function paginate( $offset , $perPage )
	{

		self::$discounts->skip($offset)
					   ->take($perPage);

	}

	static function with($entities )
	{

		return \Discount::with(parent::with($entities));

	}

}