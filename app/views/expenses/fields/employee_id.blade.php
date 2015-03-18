


<h4>Empleado</h4>  

<div class="col-sm-12">

	{{ Field::text

		(

			'employee_name', 

			null ,

			[ 

				'class' => 'col-md-10' , 

				'addon-first' => '<i class="fa fa-search"></i>' , 

				'placeholder' => 'Busca por id, nombre, correo electrónico o nombre de usuario.',

				'ng-model' => 'find_employee',

				'ng-init' => 'find_employee = "'.Input::old('employee_name').'"',

				'ng-change' => 'searchEmployee()',

				'ng-focus' => 'searchEmployee()',

				'ng-blur' => 'hideItems()',

				'ng-disabled' => '!store_id'

			]

		) 

	}}

	{{ Field::hidden

	(

		'employee_id',

		null ,

		[

			'ng-model' => 'employee_id' ,

			'ng-value' => 'employee_id' ,

			'ng-init' => 'employee_id = "'.Input::old('employee_id').'"',


		]

	)

}}   

<p class="error_message" ng-if="error_employee" >@{{ error_employee }}</p>

</div>

<section ng-show="autocompleteEmployee" class="panel col-sm-12">

	<ul class="list-group">

		<li ng-click="addEmployee(employee)" ng-repeat="employee in employees" class="list-group-item " href="#">

			@{{employee.username}}

		</li>

	</ul>

	<p ng-if="drivers.length == 0"> No se encontraron empleados. </p>

</section>