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
<div ng-app="packages">
	<div class="row"  ng-controller="ShowController" ng-init="generateAuthPermissions({{ \Auth::user()->role_id; }})">
		<aside class="profile-nav col-lg-3">
			<section class="panel">
				<div class="user-heading round">
					<a href="#">
						<img src="{{ asset('images_packs/'.$pack->image) }}" alt="">
					</a>
					<h1>{{ $pack->name }}</h1>
					<p>{{ $pack->key }}</p>
				</div>

				<ul class="nav nav-pills nav-stacked">
					<!--<li class="active"><a href="profile.html"> <i class="fa fa-user"></i>Paquete</a></li>-->
					<li ng-if="$root.auth_permissions.update.pack" ><a href="{{ route('packs.edit' , [ $pack->id ]) }}"> <i class="fa fa-edit"></i> Editar paquete</a></li>
				</ul>

			</section>
		</aside>
		<aside class="profile-info col-lg-9">

	                      <section class="panel" >
	                      	<div class="panel-heading">
	                      		<h2>Datos de paquete. </h2>
	                      	</div>
	                      	<div class="panel-body bio-graph-info">
	                      		<div class="row">
	                      			<div class="col-sm-6">
	                      				<span class="col-sm-6">Nombre </span><p class="col-sm-6"> {{ $pack->name }}</p>
	                      			</div>
	                      			<div class="col-sm-6">
	                      				<span class="col-sm-6">Código </span><p class="col-sm-6"> {{ $pack->key }}</p>
	                      			</div>
	                      			<div class="col-sm-6">
	                      				<span class="col-sm-6">Descripción</span><p class="col-sm-6"> {{ $pack->description }}</p>
	                      			</div>
	                      			<div class="col-sm-6">
	                      				<span class="col-sm-6">Precio</span><p class="col-sm-6"> {{ "<?php echo $pack->price ?>" | currency }}</p>
	                      			</div>
	                      			<div class="col-sm-6">
	                      				<span class="col-sm-6">Costo</span><p class="col-sm-6"> {{ "<?php echo $pack->cost ?>" | currency }}</p>
	                      			</div>
	                      			<div class="col-sm-6">
	                      				<span class="col-sm-6">Días de producción</span><p class="col-sm-6"> {{ $pack->production_days }}</p>
	                      			</div>
	                      			<div class="col-sm-6">
	                      				<span class="col-sm-6">Status </span><p class="col-sm-6"> {{ <?php echo $pack->status ?>  | booleanProduct }}</p>
	                      			</div>
	                      		</div>
	                      	</div>
	                      </section>

	                      @if(!empty($pack->products))
	                      <section class="panel" >
	                      	<div class="panel-heading">
	                      		<h3>Productos. </h3>
	                      	</div>
	                      </section>
	                      <section>
	                          <div class="row directory-info-row">
	                          	@foreach($pack->products as $product )
	                              <div class="col-md-6 ">
	                                  <div class="panel">
	                                      <div class="panel-body">
	                                          <div class="bio-chart ">
	                                              <img src="{{ $product->image_url}}" class="img-responsive thumb media-object" />
	                                          </div>
	                                          <div class="bio-desk">
	                                              <h4 class="red">{{ $product->name }}</h4>
	                                              <p>{{ $product->key }}</p>
	                                              <p>{{ $product->model }}</p>
	                                              <p>Cantidad: {{ $product->pivot->quantity }}</p>
	                                          </div>
	                                      </div>
	                                  </div>
	                              </div>
	                            @endforeach
	                          </div>
	                      </section>
	                      @endif
	                  </aside>
	              </div>
	            </div>
              <!-- page end-->

              @stop

              @section('sidebar_right')

              @include('sidebar_right')

              @stop


				@section('footer')

				@include('footer', ['js' => [
				'library/js/jquery-ui-1.9.2.custom.min.js' ,
				'library/js/bootstrap-switch.js' ,
				'library/js/jquery.tagsinput.js' ,
				'library/js/ga.js' ,
				'library/js/ng/packages.js',
				'library/js/ng/packages.controllers.js',
				'library/js/ng/packages.filters.js',
				'library/js/ng/packages.services.js',
				'library/js/ng/products.services.js',
				'library/js/ng/products.filters.js',
				'library/js/ng/suppliers.services.js',
				'library/js/ng/directives.js',
				'library/js/ng/ng-date.js'
				]
				]
				)

				@stop