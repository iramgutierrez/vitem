


<h4>Chofer</h4>  

<div class="col-sm-12">

	{{ Field::text

		(

			'delivery.employee_name', 

			null ,

			[ 

				'class' => 'col-md-10' , 

				'addon-first' => '<i class="fa fa-search"></i>' , 

				'placeholder' => 'Busca por id, nombre, correo electrónico o nombre de usuario.',

				'ng-model' => 'find_driver',

				'ng-change' => 'searchDriver()',

				'ng-focus' => 'searchDriver()',

				'ng-blur' => 'hideItems()'

			]

		) 

	}}

	{{ Field::hidden

	(

		'delivery.employee_id',

		null ,

		[

			'ng-model' => 'delivery_employee_id' ,

			'ng-value' => 'delivery_employee_id',

  			'ng-init' => 'driverSelectedInit(checkValuePreOrOld("'.((!empty($sale->delivery->employee_id)) ? $sale->delivery->employee_id : '').'" , "'.((Input::old('delivery.employee_id')) ? Input::old('delivery.employee_id') : '').'"))'


		]

	)

}}   

<p class="error_message" ng-if="error_employee" >@{{ error_employee }}</p>

</div>

<section ng-show="autocompleteDriver" class="panel col-sm-12">

	<ul class="list-group">

		<li ng-click="addDriver(driver)" ng-repeat="driver in drivers" class="list-group-item " href="#">

			@{{driver.username}}

		</li>

	</ul>

	<p ng-if="drivers.length == 0"> No se encontraron choferes. </p>

</section>