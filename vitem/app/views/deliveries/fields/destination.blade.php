


<h4>Destino</h4>  

<div class="col-sm-12">

	{{ Field::text

		(

			'', 

			null ,

			[ 

				'class' => 'col-md-10' , 

				'addon-first' => '<i class="fa fa-search"></i>' , 

				'placeholder' => 'Busca por código postal, colonia, delegación, municipio o estado.',

				'ng-model' => 'find_destination',

				'ng-change' => 'searchDestination()',

				'ng-focus' => 'searchDestination()',

				'ng-blur' => 'hideItems()',

				'ng-disabled' => 'newDestination'

			]

		) 

	}}

	{{ Field::hidden

	(

		'destination_id',

		null ,

		[

			'ng-model' => 'destination_id' ,

			'ng-value' => 'destination_id' 


		]

	)

}}   

<p class="error_message" ng-if="error_destination" >@{{ error_destination }}</p>

</div>

<section ng-show="autocompleteDestination" class="panel col-sm-12">

	<ul class="list-group">

		<li ng-click="addDestination(destination)" ng-repeat="destination in destinations" class="list-group-item " href="#">

			<b>@{{destination.type | destination_types }}:</b> @{{ destination.value_type }}

		</li>

	</ul>

	<p ng-if="destinations.length == 0"> No se encontraron destinos. </p>

</section>

<table class="table table-bordered table-striped table-condensed" ng-show="destination && !newDestination">
	<tr>
		<th>Tipo de destino</th>
		<th>Código postal</th>
		<th>Colonia</th>
		<th>Delegación/Municipio</th>
		<th>Estado</th>
		<th>Costo</th>
	</tr>
	<tr>
		<td>@{{destination.type | destination_types }}</td>
		<td>@{{ destination.zip_code  }}</td>
		<td>@{{ destination.colony  }}</td>
		<td>@{{ destination.town  }}</td>
		<td>@{{ destination.state }}</td>
		<td>@{{ destination.cost | currency }}</td>
	</tr>
</table>