{{ Field::text(

		'date', 
	    null , 
	    [ 
			'ui-date' => 'dateOptions',
			'ui-date-format' => 'yy-mm-dd',
			'ng-model' => 'date',
			'ng-init' => 'date = "$expense->date"',
	        'class' => 'col-md-12' , 
	        'placeholder' => '',
	        'addon-first' => '<i class="fa fa-calendar"></i>'
	    ]
    )
}}