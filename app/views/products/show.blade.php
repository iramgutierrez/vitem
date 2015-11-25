
@extends('layout')

@section('header')

@include('header' , [ 'css' => [
'library/assets/bootstrap-datepicker/css/datepicker.css',
'library/assets/bootstrap-colorpicker/css/colorpicker.css',
'library/assets/bootstrap-daterangepicker/daterangepicker.css',
'library/assets/bootstrap-fileupload/bootstrap-fileupload.css'
]
]
)

@stop

@section('sidebar_left')

@include('sidebar_left')

@stop

@section('content')

<!-- page start-->
<div class="row" ng-app="products" ng-controller="ShowController" ng-init="init({{ $product['id']; }}); getByProduct(); $root.generateAuthPermissions({{ \Auth::user()->role_id; }});" >
	<aside class="profile-nav col-lg-3">
		<section class="panel">
			<div class="user-heading round">
				<a href="#">
					<img src="{{ asset('images_products/'.$product['image']) }}" alt="">
				</a>
				<h1>{{ $product['name'] }}</h1>
				<p>{{ $product['key'] }}</p>
			</div>

			<ul class="nav nav-pills nav-stacked">
                <li ng-class="{'active' : tab == 'profile' } "><a href="" ng-click="tab = 'profile'" > <i class="fa fa-user"></i>Perfil</a></li>
                <li ng-class="{'active' : tab == 'ventas' } " ng-show="$root.auth_permissions.read.sale" ><a href="" ng-click="tab = 'ventas'" > <i class="fa fa-user"></i>Ventas</a></li>
				<li ng-show="$root.auth_permissions.update.product" ><a href="{{ route('products.edit' , [ $product['id'] ]) }}"> <i class="fa fa-edit"></i> Editar producto</a></li>
			</ul>

		</section>
	</aside>

	<aside class="profile-info col-lg-9" ng-show="tab == 'profile' ">

		<section class="panel" >
			<div class="panel-heading">
				<h2>Datos del producto. </h2>
			</div>
			<div class="panel-body bio-graph-info">
				<div class="row">
					<div class="col-sm-6">
						<span class="col-sm-6">Nombre </span><p class="col-sm-6"> {{ $product['name'] }}</p>
					</div>
					<div class="col-sm-6">
						<span class="col-sm-6">Código </span><p class="col-sm-6"> {{ $product['key'] }}</p>
					</div>
					<div class="col-sm-6">
						<span class="col-sm-6">Modelo </span><p class="col-sm-6"> {{ $product['model'] }}</p>
					</div>
					<div class="col-sm-6">
						<span class="col-sm-6">Descripción</span><p class="col-sm-6"> {{ $product['description'] }}</p>
					</div>
					@if(!empty($product['supplier']))
					<div class="col-sm-6">
						<a href="{{ $product['supplier']['url_show'] }}">
							<span class="col-sm-6">Proveedor</span><p class="col-sm-6"> {{ $product['supplier']['name'] }}</p>
						</a>
					</div>
					@endif
					<div class="col-sm-6">
						<span class="col-sm-6">Stock</span><p class="col-sm-6"> <?php echo  '{{ '.$product['stock']. ' }}' ?></p>
					</div>
					<div class="col-sm-6">
						<span class="col-sm-6">Precio</span><p class="col-sm-6"> <?php echo  '{{ '.$product['price']. '| currency }}' ?></p>
					</div>
					<div class="col-sm-6">
						<span class="col-sm-6">Costo</span><p class="col-sm-6"> <?php echo  '{{ '.$product['cost']. '| currency }}' ?></p>
					</div>
					<div class="col-sm-6">
						<span class="col-sm-6">Días de producción</span><p class="col-sm-6"> {{ $product['production_days'] }}</p>
					</div>
					<!--<div class="col-sm-6">
						<span class="col-sm-6">Status </span><p class="col-sm-6"> {{ <?php echo $product['status'] ?>  | booleanProduct }}</p>
					</div>-->
				</div>
			</div>
		</section>
	</aside>

	@if( !empty($product['sales']) )

		@include('products.sections.sales')

	@endif


              </div>

              <!-- page end-->

              @stop

              @section('sidebar_right')

              @include('sidebar_right')

              @stop

              @section('footer')

              @include('footer', ['js' => [
				'library/js/ng/products.js',
				'library/js/ng/products.controllers.js',
				'library/js/ng/products.filters.js',
				'library/js/ng/products.services.js',
				'library/js/ng/sales.services.js',
				'library/js/ng/suppliers.services.js',
                'library/js/ng/segments.services.js',
                'library/js/ng/catalogs.services.js',
              	'library/js/ng/ng-date.js',
        'library/js/ng/directives.js',
              	'library/js/jquery-ui-1.9.2.custom.min.js' ,
              	'library/js/bootstrap-switch.js' ,
              	'library/js/jquery.tagsinput.js' ,
              	'library/js/ga.js' ,
              ]
              ]
              )

              @stop