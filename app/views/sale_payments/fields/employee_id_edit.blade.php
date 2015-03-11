


<h4>Vendedor</h4>  

<div class="col-sm-12">

	{{ Field::text

		(

			'', 

			null ,

			[ 

				'class' => 'col-md-10' , 

				'addon-first' => '<i class="fa fa-search"></i>' , 

				'placeholder' => 'Busca por id, nombre, correo electrónico o nombre de usuario.',

				'ng-model' => 'find_seller',

				'ng-change' => 'searchSeller()',

				'ng-focus' => 'searchSeller()',

				'ng-blur' => 'hideItems()',

				'ng-init' => 'find_seller = "' . $sale_payment->employee->user->name . '"'

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

			'ng-init' => 'employee_id = "' . $sale_payment-> employee_id . '"'


		]

	)

}}   

</div>

<section ng-show="autocompleteSeller" class="panel col-sm-12">

	<ul class="list-group">

		<li ng-click="addSeller(seller)" ng-repeat="seller in sellers" class="list-group-item " href="#">

			@{{seller.username}}

		</li>

	</ul>

	<p ng-if="sellers.length == 0"> No se encontraron vendedores. </p>

</section>