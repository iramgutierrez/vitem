<div class="col-sm-12">

	{{ Field::text

		(

			'liquidation_date', 

			$sale->liquidation_date ,

			[ 

				'ui-date' => 'dateOptions',
                
                'ui-date-format' => 'yy-mm-dd',
                
                'ng-model' => 'liquidationDate',
                
            ]

		) 

	}}   

</div>