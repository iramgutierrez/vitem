<div class="col-sm-12">

	{{ Field::date

		(

			'liquidation_date', 

			null ,

			[ 
                
                'ng-model' => 'liquidationDate',

				'ng-init' => 'liquidationDate = checkValuePreOrOld("'.((!empty($sale->liquidation_date)) ? date( 'm/d/Y' , strtotime($sale->liquidation_date)) : '').'" , "'.((Input::old('liquidation_date')) ? date( 'm/d/Y' , strtotime(Input::old('liquidation_date'))) : '').'")',
                
            ]

		) 

	}}   

</div>