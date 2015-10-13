<?php

use Vitem\Repositories\SaleRepo;
use Vitem\Managers\SaleManager;
use Vitem\WebServices\SaleWebServices as SaleAPI;

class ReportsController extends \BaseController {

	public function __construct()
	{


		$this->beforeFilter('Admin');

		$this->beforeFilter('ACL:Sale,Read', ['only' => [ 'sales'  ] ]);

		$this->beforeFilter('ACL:User,Read', ['only' => [ 'compare_sellers' , 'compare_drivers'  ] ]);

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

		$pay_types = PayType::lists('name' , 'id');

		$filtersSaleDate = [
			'<' => 'Antes de',
			'==' => 'El dia',
			'>' => 'Después de'
 		];


		return View::make('reports/sales',compact('sale_types' , 'pay_types' , 'filtersSaleDate'));
	}

	public function compare_sellers()
	{
		return View::make('reports/compare_sellers');
	}

	public function compare_drivers()
	{
		return View::make('reports/compare_drivers');
	}

	public function generateXls()
	{
		\Debugbar::disable();

		$employee_id = (!empty(Input::only('employee_id')['employee_id'])) ? Input::only('employee_id')['employee_id'] : false;

		$client_id = (!empty(Input::only('client_id')['client_id'])) ? Input::only('client_id')['client_id'] : false;

		$sale_type = (!empty(Input::only('sale_type')['sale_type'])) ? Input::only('sale_type')['sale_type'] : false;

		$pay_type_id = (!empty(Input::only('pay_type_id')['pay_type_id'])) ? Input::only('pay_type_id')['pay_type_id'] : false;

		$initDate = (!empty(Input::only('initDate')['initDate'])) ? Input::only('initDate')['initDate'] : false;

		$endDate = (!empty(Input::only('endDate')['endDate'])) ? Input::only('endDate')['endDate'] : false;

		$percent_cleared_payment_type = (!empty(Input::only('percent_cleared_payment_type')['percent_cleared_payment_type'])) ? Input::only('percent_cleared_payment_type')['percent_cleared_payment_type'] : false;

		$percent_cleared_payment = (!empty(Input::only('percent_cleared_payment')['percent_cleared_payment'])) ? Input::only('percent_cleared_payment')['percent_cleared_payment'] : false;

		$sales =  SaleRepo::findReport($employee_id , $client_id  , $sale_type , $pay_type_id , $initDate , $endDate , $percent_cleared_payment_type , $percent_cleared_payment);

		header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
		header("Content-Disposition: attachment; filename=reporte_ventas_".date('Y-m-d_H-i-s').".xls");  //File name extension was wrong
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Cache-Control: private",false);

		return View::make('reports/sales_xls',compact('sales'));

	}

	public function generateCustomXls()
	{
		$headers = Input::get('headersExport');

		$data = Input::get('dataExport');

		if(empty($headers) || !$data)
		{
			Session::flash('error' , 'No se recibieron datos correctos para generar el archivo.');

            return Redirect::back();
		}

		$headers = json_decode($headers , true);

		$data = json_decode($data , true);

		if( !isset($headers[0]['field']) || !isset($headers[0]['label']) )
		{
			Session::flash('error' , 'No se recibieron datos correctos para generar el archivo.');

            return Redirect::back();
		}

		$headerXLS = [];

		foreach($headers as $header)
		{
			$headerXLS = '';

			if(!empty($header['field']))
			{

				if( is_array($header['field']) )
				{
					foreach($header['field'] as $k => $v)
					{
						if(!is_null($v))
						{
							$subkey = $k;

							$subheader = $v;

							break;

						}
					}

					/*$subkey = array_keys($header['field'])[0];

					$subheader = array_values($header['field'])[0];*/

					$headerXLS = $this->getLabelArray($subheader);

				}else
				{
					$headerXLS = $header['field'];
				}
			}

			$headersXLS[] = [
				'field' => $headerXLS,
				'label' => $header['label']
			];

		}
		$dataXLS = [];

		foreach($data as $key => $record)
		{
			$recordXLS = [];

			foreach($headers as $header)
			{
				$fieldXLS = '';

				$labelXLS = '';

				if(!empty($header['field']))
				{

					if( is_array($header['field']) )
					{

						foreach($header['field'] as $k => $v)
						{
							if(!is_null($v))
							{
								$subkey = $k;

								$subheader = $v;

								break;

							}
						}

						if(isset($record[$subkey]))
						{

							$fieldXLS = $this->getFieldArray($subheader , $record[$subkey]);

						}

					}else
					{
						if(isset($record[ $header['field'] ]))
							$fieldXLS = $record[ $header['field'] ];
					}
				}

				$recordXLS[] = $fieldXLS;

			}

			$dataXLS[] = $recordXLS;

		}

		if(!is_array($headers) || !is_array($data))
		{
			Session::flash('error' , 'No se recibieron datos correctos para generar el archivo.');

            return Redirect::back();
		}

		$filename = (Input::has('filename')) ? Input::get('filename') : 'reporte';

		header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
		header("Content-Disposition: attachment; filename=".$filename."_".date('Y-m-d_H-i-s').".xls");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Cache-Control: private",false);

		return View::make('reports/generate_custom_xls',compact('headersXLS' , 'dataXLS'));

	}

	private function getLabelArray($field)
	{
		if( is_array($field) )
		{
			foreach($field as $k => $v)
			{
				if(!is_null($v))
				{
					$subkey = $k;

					$subheader = $v;

					break;

				}
			}
			/*$subkey = array_keys($field)[0];

			$subheader = array_values($field)[0];*/

			$headerXLS = $this->getLabelArray($subheader);

		}else
		{
			$headerXLS = $field;
		}

		return $headerXLS;
	}

	private function getFieldArray($field , $record)
	{
		$fieldXLS = '';

		if( is_array($field) )
		{
			foreach($field as $k => $v)
			{
				if(!is_null($v))
				{
					$subkey = $k;

					$subheader = $v;

					break;

				}
			}

			/*$subkey = array_keys($field)[0];

			$subheader = array_values($field)[0];*/

			if(isset($record[$subkey]))
			{

				$fieldXLS = $this->getFieldArray($subheader ,  $record[$subkey]);

			}

		}else
		{
			if(isset($record[ $field ]))
				$fieldXLS = $record[ $field ];
		}

		return $fieldXLS;
	}

}