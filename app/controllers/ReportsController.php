<?php

use Vitem\Repositories\SaleRepo;
use Vitem\Managers\SaleManager;
use Vitem\WebServices\SaleWebServices as SaleAPI;

class ReportsController extends \BaseController {

	public function __construct()
	{

		$this->beforeFilter('ACL:Sale,Read', ['only' => [ 'sales'  ] ]);
		
	}

	/**
	 * Display a listing of the resource.
	 * GET /sales
	 *
	 * @return Response
	 */
	public function sales()
	{
		$sale_types = [
			'apartado' => 'Apartado',
			'contado' => 'Contado'
		];

		$pay_types = [
			'efectivo' => 'Efectivo',
			'tarjeta' => 'Tarjeta',
			'cheque' => 'Cheque'
		];

		$filtersSaleDate = [
			'<' => 'Antes de',
			'==' => 'El dia',
			'>' => 'Después de'
 		];


		return View::make('reports/sales',compact('sale_types' , 'pay_types' , 'filtersSaleDate'));
	}	

	public function generateXls()
	{ 

		$employee_id = (!empty(Input::only('employee_id')['employee_id'])) ? Input::only('employee_id')['employee_id'] : false;

		$client_id = (!empty(Input::only('client_id')['client_id'])) ? Input::only('client_id')['client_id'] : false;

		$sale_type = (!empty(Input::only('sale_type')['sale_type'])) ? Input::only('sale_type')['sale_type'] : false;

		$pay_type = (!empty(Input::only('pay_type')['pay_type'])) ? Input::only('pay_type')['pay_type'] : false;

		$initDate = (!empty(Input::only('initDate')['initDate'])) ? Input::only('initDate')['initDate'] : false;

		$endDate = (!empty(Input::only('endDate')['endDate'])) ? Input::only('endDate')['endDate'] : false;

		$sales =  SaleRepo::findReport($employee_id , $client_id  , $sale_type , $pay_type , $initDate , $endDate );


		//dd($sales);
		
		header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
		header("Content-Disposition: attachment; filename=reporte_ventas_".date('Y-m-d_H-i-s').".xls");  //File name extension was wrong
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Cache-Control: private",false);

		return View::make('reports/sales_xls',compact('sales'));

		//dd($sales);
	}

}