<div class="col-sm-12">

	{{ Field::date

		(

			'init_date', 

			null ,

			[ 

				'class' => 'col-md-10' , 

				'ng-model' => 'init_date',

                'ng-init' => 'init_date = "'.date( 'm/d/Y' , time() - (30 * 24 * 60 * 60)).'"',

                'format-date'

			]

		) 

	}}   

</div>