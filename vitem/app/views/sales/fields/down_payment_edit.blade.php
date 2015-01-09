<div class="col-sm-12">

	{{ Field::text

		(

			'down_payment', 

			(isset($sale->sale_payments[0])) ? $sale->sale_payments[0]->quantity : null ,

			[
	
				'addon-first' => '$' , 

			]

		) 

	}}  

</div>