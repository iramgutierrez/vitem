{{ Field::hidden

	(

		'client_id',

		null ,

		[

			'ng-model' => '$root.client_id' ,

			'ng-value' => '$root.client_id',

  			'ng-init' => 'clientSelectedInit(checkValuePreOrOld("'.((!empty($sale->client_id)) ? $sale->client_id : '').'" , "'.((Input::old('client_id')) ? Input::old('client_id') : '').'"))'


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

				'ng-model' => '$root.find_client',

				'ng-change' => 'searchClient()',

				'ng-focus' => 'searchClient()',

				'ng-blur' => 'hideItems()'

			]

		) 

	}}   

</div>

<section ng-show="$root.autocompleteClient" class="panel col-sm-12">

	<ul class="list-group">

		<li ng-click="$root.addClient(client)" ng-repeat="client in clients" class="list-group-item " href="#">

			@{{client.name}}

		</li>

	</ul>

	<p ng-if="clients.length == 0"> No se encontraron clientes. </p>

</section>