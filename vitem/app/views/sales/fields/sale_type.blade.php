<div class="col-sm-12">
	{{ Field::select

		(

			'sale_type', 

			$sales_types,

			'' ,

			[
			
				'ng-model' => 'sale_type',

				'ng-init' => isset(Input::old()['sale_type']) ? 'sale_type = "'.Input::old()['sale_type'].'"' : '' 
				
			]

		) 

	}}   

</div>