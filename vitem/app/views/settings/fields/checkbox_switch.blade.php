<div class="col-sm-12 col-md-12">

	{{ Field::checkbox_switch(

		    'town', 
			null ,
			[ 
				'class' => 'col-md-12' , 
				'bs-switch',
				'ng-model' => 'town',
				'ng-init' => "town = '".Input::old('town')."'",
				'switch-on-text' => '<i class="fa fa-power-off"></i>',
				'switch-off-text' => '<i class="fa fa-power-off"></i>',
				'switch-label' => '',
				'switch-size' => 'normal',
				'ng-true-value' => '1',
				'ng-false-value' => '0'
			],
			[
			  	'label-value' => 'df'
			]

		)

	}}

</div>