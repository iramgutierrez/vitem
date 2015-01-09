<div class="col-sm-12 col-md-12">

	{{ Field::checkbox_switch(

		    'setting.add_residue_new_expense', 
			null ,
			[ 
				'class' => 'col-md-12' , 
				'bs-switch',
				'ng-model' => 'add_residue_new_expense',
				'ng-init' => "add_residue_new_expense = '".Input::old('add_residue_new_expense')."'",
				'switch-on-text' => '<i class="fa fa-power-off"></i>',
				'switch-off-text' => '<i class="fa fa-power-off"></i>',
				'switch-label' => '',
				'switch-size' => 'normal',
				'ng-true-value' => '1',
				'ng-false-value' => '0'
			],
			[
			  	'label-value' => 'Restar al saldo de la empresa automaticamente al generarse un gasto.'
			]

		)

	}}

</div>