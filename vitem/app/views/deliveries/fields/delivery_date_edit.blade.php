<div class="col-sm-12 col-md-12">

	{{ Field::text

		(

			'delivery_date', 

			$delivery->delivery_date,

			[ 
            
            	'ui-date' => 'dateOptions',
                'ui-date-format' => 'yy-mm-dd',
                'ng-model' => 'delivery_date',
                'ng-init' => 'delivery_date = "$delivery->delivery_date"',
                'placeholder' => ''
            ]

		) 

	}}  

</div>

