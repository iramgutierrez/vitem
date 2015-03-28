<h4>Vendedor 2</h4>  

<div class="col-sm-12">

	{{ Field::text

		(

			'', 

			null ,

			[ 

				'class' => 'col-md-10' , 

				'addon-first' => '<i class="fa fa-search"></i>' , 

				'placeholder' => 'Busca por id, nombre, correo electrónico o nombre de usuario.',

				'ng-model' => 'find_seller_2',

				'ng-change' => 'searchSeller2()',

				'ng-focus' => 'searchSeller2()',

				'ng-blur' => 'blurSeller2()'

			]

		) 

	}}   

</div>

<section ng-show="autocompleteSeller_2" class="panel col-sm-12">

	<ul class="list-group">

		<li ng-click="addSeller2(seller)" ng-repeat="seller in sellers" class="list-group-item " href="#">

			@{{seller.username}}

		</li>

	</ul>

	<p ng-if="sellers.length == 0"> No se encontraron vendedores. </p>

</section>