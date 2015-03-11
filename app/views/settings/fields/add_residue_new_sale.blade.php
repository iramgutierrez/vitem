<div class="col-sm-12 col-md-12">

	{{ Form::hidden('add_residue_new_sale', false); }}

	{{ Field::checkbox_switch(

		    'add_residue_new_sale', 
			null ,
			[ 
				'class' => 'col-md-12' , 
				'bs-switch',
				'ng-model' => 'add_residue_new_sale',
				'ng-value' => 'add_residue_new_sale',
				'ng-init' => (isset($settings['add_residue_new_sale'])) ?  "add_residue_new_sale = ".$settings['add_residue_new_sale'] : "add_residue_new_sale = false",
				'switch-on-text' => '<i class="fa fa-power-off"></i>',
				'switch-off-text' => '<i class="fa fa-power-off"></i>',
				'switch-label' => '',
				'switch-size' => 'normal',
				'ng-true-value' => 'true',
				'ng-false-value' => 'false',	
				'ng-focus' => 'add_residue_new_sale = switchValue(add_residue_new_sale)'
			],
			[
			  	'label-value' => 'Agregar/Restar al saldo de la empresa automáticamente al realizarse o editarse una venta'
			]

		)

	}}

</div>