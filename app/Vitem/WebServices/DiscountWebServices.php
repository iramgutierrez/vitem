<?php namespace Vitem\WebServices;

use Vitem\Repositories\DiscountRepo;


class DiscountWebServices extends BaseWebServices {

	/*public function getModel()
	{
		return new User;
	}*/

	static function all()
	{

		return \Response::json(\Discount::with(['item' , 'pay_types','stores'])->get());

	}
	static function findById()
	{
		$id = (isset($_GET['id'])) ? $_GET['id'] : false;

		if(!$id)
			return false;


		$destination = \Discount::where('id' , $id)->first();

		return \Devolution::json($destination);

	}
	static function find()
	{

		$page = (!empty($_GET['page'])) ? $_GET['page'] : 1;

		$perPage = (!empty($_GET['perPage'])) ? $_GET['perPage'] : 50;

		$find = (!empty($_GET['find'])) ? $_GET['find'] : '';

        $type = (!empty($_GET['type'])) ? $_GET['type'] : '';

        $initDate = (!empty($_GET['initDate'])) ? $_GET['initDate'].' 00:00:00' : false;

        $endDate = (!empty($_GET['endDate'])) ? $_GET['endDate'].' 23:59:59' : false;

        $discountType = (!empty($_GET['discountType'])) ? $_GET['discountType'] : '';

        $store = (!empty($_GET['store'])) ? $_GET['store'] : '';

        $payType = (!empty($_GET['pay_type'])) ? $_GET['pay_type'] : '';

		$discounts = [

			'data' => DiscountRepo::findByPage($page , $perPage , $find , $type , $initDate , $endDate , $discountType , $store , $payType ),
			'total' => DiscountRepo::countFind($find , $type , $initDate , $endDate , $discountType,$store , $payType )
		];

		return \Response::json($discounts);
	}
}