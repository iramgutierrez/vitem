<div class="col-sm-12">

	{{ Field::text

		(

			'percent', 

			null ,

			[
	
				'addon-first' => '%' , 

				'ng-model' => 'percent',

				'ng-change' => 'getTotal()'

			]

		) 

	}}  

	<p class="error_message" ng-if="error_percent" >@{{ error_percent }}</p> 

</div>