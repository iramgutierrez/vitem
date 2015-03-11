{{ Field::hidden

	(

		'employee_id',

		null ,

		[

			'ng-model' => 'employee_id' ,

			'ng-value' => 'employee_id' 


		]

	)

}}


<h4>Vendedor</h4>  

<div class="col-sm-12">

	{{ Field::text

		(

			'', 

			null ,

			[ 

				'class' => 'col-md-10' , 

				'addon-first' => '<a ng-click="newProduct = 0" style="cursor:pointer;"><i class="fa fa-search"></i></a>' , 

				'placeholder' => 'Busca por id, nombre, correo electrónico o nombre de usuario.',

				'ng-model' => 'find_seller',

				'ng-change' => 'searchSeller()',

				'ng-focus' => 'searchSeller()',

				'ng-blur' => 'hideItems()'

			]

		) 

	}}   

</div>

<section ng-show="autocomplete" class="panel col-sm-12">

	<ul class="list-group">

		<li ng-click="addSeller(seller)" ng-repeat="seller in sellers" class="list-group-item " href="#">

			@{{seller.username}}

		</li>

	</ul>

	<p ng-if="sellers.length == 0"> No se encontraron vendedores. </p>

</section>