<div class="col-sm-12">
	
	{{ Field::date

		(

			'sale_date', 

			null ,

			[ 				
                
                'ng-model' => 'saleDate',

				'ng-init' => 'saleDate = checkValuePreOrOld("'.((!empty($sale->sale_date)) ? date( 'm/d/Y' , strtotime($sale->sale_date)) : '').'" , "'.((Input::old('sale_date')) ? date( 'm/d/Y' , strtotime(Input::old('sale_date'))) : '').'")',

				'format-date'
                
            ]

		) 

	}}   

</div>