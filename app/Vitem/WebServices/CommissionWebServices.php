<?php namespace Vitem\WebServices;

use Vitem\Repositories\CommissionRepo;


class CommissionWebServices extends BaseWebServices {

	/*public function getModel()
	{
		return new User;
	}*/

	static function all()
	{

		$commissions = CommissionRepo::all();

		return \Response::json($commissions);
		
	}
	
	static function findById()
	{
		$id = (isset($_GET['id'])) ? $_GET['id'] : false;

		if(!$id)
			return false;


		$commission = CommissionRepo::with(['employee.user', 'sale.employee.user', 'sale.sale_payments.employee.user' ,'sale_payments.employee.user']);

		$usersPermitted = \ACLFilter::generateAuthCondition();

		if(count($usersPermitted))
		{
			$commission = $commission->whereIn('employee_id' , $usersPermitted);
		}

		$commission = $commission->where('id' , $id)->first();

		return \Response::json($commission);

	}

}