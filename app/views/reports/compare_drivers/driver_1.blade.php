<h4>Chofer 1</h4>  

<div class="col-sm-12">

	<?php echo Field::text

		(

			'', 

			null ,

			[ 

				'class' => 'col-md-10' , 

				'addon-first' => '<i class="fa fa-search"></i>' , 

				'placeholder' => 'Busca por id, nombre, correo electrónico o nombre de usuario.',

				'ng-model' => 'find_driver_1',

				'ng-change' => 'searchDriver1()',

				'ng-focus' => 'searchDriver1()',

				'ng-blur' => 'searchDriver1()'

			]

		) 

	?>  

</div>

<section ng-show="autocompleteDriver_1" class="panel col-sm-12">

	<ul class="list-group">

		<li ng-click="addDriver1(driver)" ng-repeat="driver in drivers" class="list-group-item " href="#">

			@{{driver.name}}

		</li>

	</ul>

	<p ng-if="drivers.length == 0"> No se encontraron choferes. </p>

</section>