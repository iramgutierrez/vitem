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

        $with = [
            'item'
        ];


        if($store)
        {
            $Store = \Store::find($store);

            if($Store)
            {
                $with['stores'] = function($query) use ($Store){
                    $query->where('stores.id', '=', $Store->id);
                };
            }
            else
            {
                $with[] = 'stores';
            }
        }
        else
        {
            $with[] = 'stores';
        }


        if($payType)
        {
            $PayType = \Store::find($payType);

            if($PayType)
            {
                $with['pay_types'] = function($query) use ($PayType){
                    $query->where('pay_types.id', '=', $PayType->id);
                };
            }
            else
            {
                $with[] = 'pay_types';
            }
        }
        else
        {
            $with[] = 'pay_types';
        }

        self::$discounts = \Discount::with($with);

		self::generateLikeCondition( $find , ['id']);

        self::generateTypeCondition( $type);

        self::generateInitDateCondition( $initDate);

        self::generateEndDateCondition( $endDate);

        self::generateDiscountTypeCondition( $discountType);

		$whereUserId = \ACLFilter::generateAuthCondition();

		if(count($whereUserId))
			self::$discounts->whereIn( 'user_id' , $whereUserId);

		self::paginate($offset , $perPage);

		return self::$discounts->get();

	}

	static function countFind($find , $type , $initDate , $endDate , $discountType, $store , $payType)
	{

        $with = [
            'item'
        ];


        if($store)
        {
            $Store = \Store::find($store);

            if($Store)
            {
                $with['stores'] = function($query) use ($Store){
                    $query->where('stores.id', '=', $Store->id);
                };
            }
            else
            {
                $with[] = 'stores';
            }
        }
        else
        {
            $with[] = 'stores';
        }


        if($payType)
        {
            $PayType = \Store::find($payType);

            if($PayType)
            {
                $with['pay_types'] = function($query) use ($PayType){
                    $query->where('pay_types.id', '=', $PayType->id);
                };
            }
            else
            {
                $with[] = 'pay_types';
            }
        }
        else
        {
            $with[] = 'pay_types';
        }

        self::$discounts = \Discount::with($with);

		self::generateLikeCondition( $find , ['id']);

        self::generateTypeCondition( $type);

        self::generateInitDateCondition( $initDate);

        self::generateEndDateCondition( $endDate);

        self::generateDiscountTypeCondition( $discountType);

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
                ->stores()->where('store_id' , $store);
        }
    }

    private static function generatePayTypeCondition($payType)
    {
        if($payType)
        {
            self::$discounts
                ->pay_types()->where('pay_type_id' , $payType);
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