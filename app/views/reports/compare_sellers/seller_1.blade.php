<h4>Vendedor 1</h4>  

<div class="col-sm-12">

	<?php echo Field::text

		(

			'', 

			null ,

			[ 

				'class' => 'col-md-10' , 

				'addon-first' => '<i class="fa fa-search"></i>' , 

				'placeholder' => 'Busca por id, nombre, correo electrónico o nombre de usuario.',

				'ng-model' => 'find_seller_1',

				'ng-change' => 'searchSeller1()',

				'ng-focus' => 'searchSeller1()',

				'ng-blur' => 'blurSeller1()'

			]

		) 

	?>  

</div>

<section ng-show="autocompleteSeller_1" class="panel col-sm-12">

	<ul class="list-group">

		<li ng-click="addSeller1(seller)" ng-repeat="seller in sellers" class="list-group-item " href="#">

			@{{seller.username}}

		</li>

	</ul>

	<p ng-if="sellers.length == 0"> No se encontraron vendedores. </p>

</section>