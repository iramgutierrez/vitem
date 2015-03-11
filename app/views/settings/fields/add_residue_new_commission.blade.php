<div class="col-sm-12 col-md-12">

	{{ Form::hidden('add_residue_new_commission', false); }}

	{{ Field::checkbox_switch(

		    'add_residue_new_commission', 
			null ,
			[ 
				'class' => 'col-md-12' , 
				'bs-switch',
				'ng-model' => 'add_residue_new_commission',
				'ng-value' => 'add_residue_new_commission',
				'ng-init' => (isset($settings['add_residue_new_commission'])) ?  "add_residue_new_commission = ".$settings['add_residue_new_commission'] : "add_residue_new_commission = false",
				'switch-on-text' => '<i class="fa fa-power-off"></i>',
				'switch-off-text' => '<i class="fa fa-power-off"></i>',
				'switch-label' => '',
				'switch-size' => 'normal',
				'ng-true-value' => 'true',
				'ng-false-value' => 'false',	
				'ng-focus' => 'add_residue_new_commission = switchValue(add_residue_new_commission)'
			],
			[
			  	'label-value' => 'Agregar/Restar al saldo de la empresa automáticamente al asignarse, editarse o eliminarse una comisión.'
			]

		)

	}}

</div>