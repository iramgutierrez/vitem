<div class="col-sm-12 col-md-12">

	{{ Form::hidden('add_residue_new_sale_payment', false); }}

	{{ Field::checkbox_switch(

		    'add_residue_new_sale_payment', 
			null ,
			[ 
				'class' => 'col-md-12' , 
				'bs-switch',
				'ng-model' => 'add_residue_new_sale_payment',
				'ng-value' => 'add_residue_new_sale_payment',
				'ng-init' => (isset($settings['add_residue_new_sale_payment'])) ?  "add_residue_new_sale_payment = ".$settings['add_residue_new_sale_payment'] : "add_residue_new_sale_payment = false",
				'switch-on-text' => '<i class="fa fa-power-off"></i>',
				'switch-off-text' => '<i class="fa fa-power-off"></i>',
				'switch-label' => '',
				'switch-size' => 'normal',
				'ng-true-value' => 'true',
				'ng-false-value' => 'false',	
				'ng-focus' => 'add_residue_new_sale_payment = switchValue(add_residue_new_sale_payment)'			
			],
			[
			  	'label-value' => 'Agregar/Editar al saldo de la empresa automáticamente al recibirse, editarse o eliminarse un abono.'
			]

		)

	}}

</div>