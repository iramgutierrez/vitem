<h4>Buscar producto</h4>  

<div class="col-sm-12">

	{{ Field::text

		(

			'', 

			null ,

			[ 

				'class' => 'col-md-10' , 

				'addon-first' => '<i class="fa fa-search"></i>' , 

				'placeholder' => 'Busca por id, nombre, código o modelo.',

				'ng-model' => 'find',

				'ng-change' => 'search()',

				'ng-focus' => 'search()',

				'ng-blur' => 'hideItems()'

			]

		) 

	}}   

	<section ng-if="autocomplete" class="panel col-sm-12">

		<ul class="list-group">

			<li ng-click="addProduct(product)" ng-repeat="product in products" class="list-group-item " href="#">

				@{{product.name}}

			</li>

		</ul>

		<p ng-if="products.length == 0"> No se encontraron productos. </p>

	</section>

</div>