<div class="col-sm-12 col-md-12">

	{{ Form::hidden('add_residue_new_expense', false); }}

	{{ Field::checkbox_switch(

		    'add_residue_new_expense', 
			null ,
			[ 
				'class' => 'col-md-12' , 
				'bs-switch',
				'ng-model' => 'add_residue_new_expense',
				'ng-value' => 'add_residue_new_expense',
				'ng-init' => (isset($settings['add_residue_new_expense'])) ?  "add_residue_new_expense = ".$settings['add_residue_new_expense'] : "add_residue_new_expense = false",
				'switch-on-text' => '<i class="fa fa-power-off"></i>',
				'switch-off-text' => '<i class="fa fa-power-off"></i>',
				'switch-label' => '',
				'switch-size' => 'normal',
				'ng-true-value' => 'true',
				'ng-false-value' => 'false',	
				'ng-focus' => 'add_residue_new_expense = switchValue(add_residue_new_expense)'			
			],
			[
			  	'label-value' => 'Agregar/Restar al saldo de la empresa automáticamente al generarse, editarse o eliminarse un gasto.'
			]

		)

	}}

</div>