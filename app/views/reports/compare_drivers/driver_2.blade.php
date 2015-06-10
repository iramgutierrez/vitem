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

				'ng-model' => 'find_driver_2',

				'ng-change' => 'searchDriver2()',

				'ng-focus' => 'searchDriver2()',

				'ng-blur' => 'blurDriver2()'

			]

		) 

	}}   

</div>

<section ng-show="autocompleteDriver_2" class="panel col-sm-12">

	<ul class="list-group">

		<li ng-click="addDriver2(driver)" ng-repeat="driver in drivers" class="list-group-item " href="#">

			@{{driver.name}}

		</li>

	</ul>

	<p ng-if="drivers.length == 0"> No se encontraron choferes. </p>

</section>