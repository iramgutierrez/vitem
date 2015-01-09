<div class="col-sm-12">

	{{ Field::text

		(

			'sale_date', 

			date('Y-m-d') ,

			[ 

				'ui-date' => 'dateOptions',
                
                'ui-date-format' => 'yy-mm-dd',
                
                'ng-model' => 'saleDate',
                
            ]

		) 

	}}   

</div>