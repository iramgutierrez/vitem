<div class="col-sm-12 col-md-12">

	{{ Form::hidden('add_residue_new_order', false); }}

	{{ Field::checkbox_switch(

		    'add_residue_new_order',
			null ,
			[ 
				'class' => 'col-md-12' , 
				'bs-switch',
				'ng-model' => 'add_residue_new_order',
				'ng-value' => 'add_residue_new_order',
				'ng-init' => (isset($settings['add_residue_new_order'])) ?  "add_residue_new_order = ".$settings['add_residue_new_order'] : "add_residue_new_order = false",
				'switch-on-text' => '<i class="fa fa-power-off"></i>',
				'switch-off-text' => '<i class="fa fa-power-off"></i>',
				'switch-label' => '',
				'switch-size' => 'normal',
				'ng-true-value' => 'true',
				'ng-false-value' => 'false',	
				'ng-focus' => 'add_residue_new_order = switchValue(add_residue_new_order)'
			],
			[
			  	'label-value' => 'Agregar/Restar al saldo de la empresa automáticamente al generarse, editarse o eliminarse un pedido.'
			]

		)

	}}

</div>