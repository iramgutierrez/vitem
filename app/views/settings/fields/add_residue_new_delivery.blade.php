<div class="col-sm-12 col-md-12">

	{{ Form::hidden('add_residue_new_delivery', false); }}

	{{ Field::checkbox_switch(

		    'add_residue_new_delivery',
			null ,
			[ 
				'class' => 'col-md-12' , 
				'bs-switch',
				'ng-model' => 'add_residue_new_delivery',
				'ng-value' => 'add_residue_new_delivery',
				'ng-init' => (isset($settings['add_residue_new_delivery'])) ?  "add_residue_new_delivery = ".$settings['add_residue_new_delivery'] : "add_residue_new_delivery = false",
				'switch-on-text' => '<i class="fa fa-power-off"></i>',
				'switch-off-text' => '<i class="fa fa-power-off"></i>',
				'switch-label' => '',
				'switch-size' => 'normal',
				'ng-true-value' => 'true',
				'ng-false-value' => 'false',	
				'ng-focus' => 'add_residue_new_delivery = switchValue(add_residue_new_delivery)'
			],
			[
			  	'label-value' => 'Agregar/Restar al saldo de la empresa automáticamente al generarse, editarse o eliminarse una entrega.'
			]

		)

	}}

</div>