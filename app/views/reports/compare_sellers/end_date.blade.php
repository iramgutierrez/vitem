<div class="col-sm-12">

	{{ Field::date

		(

			'end_date', 

			null ,

			[ 

				'class' => 'col-md-10' , 

				'ng-model' => 'end_date',

                'ng-init' => 'end_date = "'.date( 'm/d/Y' , time() + (24 * 60 * 60) ).'"',

                'format-date'

			]

		) 

	}}   

</div>