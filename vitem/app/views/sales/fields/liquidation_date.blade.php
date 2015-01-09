<div class="col-sm-12">

	{{ Field::text

		(

			'liquidation_date', 

			null ,

			[ 

				'ui-date' => 'dateOptions',
                
                'ui-date-format' => 'yy-mm-dd',
                
                'ng-model' => 'liquidationDate',
                
            ]

		) 

	}}   

</div>