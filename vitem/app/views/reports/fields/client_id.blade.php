{{ Field::hidden

	(

		'client_id',

		null ,

		[

			'ng-model' => 'client_id' ,

			'ng-value' => 'client_id' ,

			'ng-change' => 'search()'


		]

	)

}}


<h4>Cliente</h4>  

<div class="col-sm-12">

	{{ Field::text

		(

			'', 

			null ,

			[ 

				'class' => 'col-md-10' , 

				'addon-first' => '<i class="fa fa-search"></i>' , 

				'placeholder' => 'Busca por id, nombre o correo electrónico.',

				'ng-model' => 'find_client',

				'ng-change' => 'searchClient()',

				'ng-focus' => 'searchClient()',

				'ng-blur' => 'blurClient()'

			]

		) 

	}}   

</div>

<section ng-show="autocompleteClient" class="panel col-sm-12">

	<ul class="list-group">

		<li ng-click="addClient(client)" ng-repeat="client in clients" class="list-group-item " href="#">

			@{{client.name}}

		</li>

	</ul>

	<p ng-if="clients.length == 0"> No se encontraron clientes. </p>

</section>