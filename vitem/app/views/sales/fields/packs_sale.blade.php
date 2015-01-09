<h4>Buscar paquete</h4>  

<div class="col-sm-12">

	{{ Field::text

		(

			'', 

			null ,

			[ 

				'class' => 'col-md-10' , 

				'addon-first' => '<i class="fa fa-search"></i>' , 

				'placeholder' => 'Busca por id, nombre o código',

				'ng-model' => 'find_pack',

				'ng-change' => 'searchPack()',

				'ng-focus' => 'searchPack()',

				'ng-blur' => 'hideItems()'

			]

		) 

	}}

	<section ng-if="autocompletePack" class="panel col-sm-12">

		<ul class="list-group">

			<li ng-click="addPack(pack)" ng-repeat="pack in packs" class="list-group-item " href="#">

				@{{pack.name}}

			</li>

		</ul>

		<p ng-if="packs.length == 0"> No se encontraron paquetes. </p>

	</section>

</div>

