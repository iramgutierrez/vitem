<div class="col-sm-12">

	{{ Field::select

		(

			'sale_type', 

			$sales_types,

			null ,

			[
			
				'ng-model' => 'sale_type',

				'ng-init' => 'sale_type = "'. $sale->sale_type. '"'
				
			]

		) 

	}}   

</div>