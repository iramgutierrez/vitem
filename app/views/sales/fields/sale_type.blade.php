<div class="col-sm-12">

	{{ Field::select

		(

			'sale_type', 

			$sales_types,

			'' ,

			[
			
				'ng-model' => 'sale_type',

				'ng-init' => 'sale_type = checkValuePreOrOld("'.((!empty($sale->sale_type)) ? $sale->sale_type : '').'" , "'.((Input::old('sale_type')) ? Input::old('sale_type') : '').'")'
				
			]

		) 

	}}

</div>