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
<div class="row" ng-app="products" >
	<aside class="profile-nav col-lg-3">
		<section class="panel">
			<div class="user-heading round">
				<a href="#">
					<img src="{{ asset('images_products/'.$product->image) }}" alt="">
				</a>
				<h1>{{ $product->name }}</h1>
				<p>{{ $product->key }}</p>
			</div>

			<ul class="nav nav-pills nav-stacked">
				<li class="active"><a href="profile.html"> <i class="fa fa-user"></i>Perfil</a></li>
				<li><a href="profile-activity.html"> <i class="fa fa-calendar"></i>Actividad reciente</a></li>
				<li><a href="{{ route('products.edit' , [ $product->id ]) }}"> <i class="fa fa-edit"></i> Editar usuario</a></li>
			</ul>

		</section>
	</aside>
	<aside class="profile-info col-lg-9">
                      <!--<section class="panel">
                          <form>
                              <textarea placeholder="Whats in your mind today?" rows="2" class="form-control input-lg p-text-area"></textarea>
                          </form>
                          <footer class="panel-footer">
                              <button class="btn btn-danger pull-right">Post</button>
                              <ul class="nav nav-pills">
                                  <li>
                                      <a href="#"><i class="fa fa-map-marker"></i></a>
                                  </li>
                                  <li>
                                      <a href="#"><i class="fa fa-camera"></i></a>
                                  </li>
                                  <li>
                                      <a href="#"><i class=" fa fa-film"></i></a>
                                  </li>
                                  <li>
                                      <a href="#"><i class="fa fa-microphone"></i></a>
                                  </li>
                              </ul>
                          </footer>
                      </section>-->

                      <section class="panel" ng-controller="ProductsController">
                      	<div class="panel-heading">
                      		<h2>Datos de producto. </h2>
                      	</div>
                      	<div class="panel-body bio-graph-info">
                      		<div class="row">
                      			<div class="col-sm-6">
                      				<span class="col-sm-6">Nombre </span><p class="col-sm-6"> {{ $product->name }}</p>
                      			</div>
                      			<div class="col-sm-6">
                      				<span class="col-sm-6">Código </span><p class="col-sm-6"> {{ $product->key }}</p>
                      			</div>
                      			<div class="col-sm-6">
                      				<span class="col-sm-6">Modelo </span><p class="col-sm-6"> {{ $product->model }}</p>
                      			</div>
                      			<div class="col-sm-6">
                      				<span class="col-sm-6">Descripción</span><p class="col-sm-6"> {{ $product->description }}</p>
                      			</div>
                      			<div class="col-sm-6">
                      				<span class="col-sm-6">Precio</span><p class="col-sm-6"> {{ $product->price }}</p>
                      			</div>
                      			<div class="col-sm-6">
                      				<span class="col-sm-6">Costo</span><p class="col-sm-6"> {{ $product->cost }}</p>
                      			</div>
                      			<div class="col-sm-6">
                      				<span class="col-sm-6">Días de producción</span><p class="col-sm-6"> {{ $product->production_days }}</p>
                      			</div>
                      			<div class="col-sm-6">
                      				<span class="col-sm-6">Status </span><p class="col-sm-6"> {{ <?php echo $product->status ?>  | booleanProduct }}</p>
                      			</div>
                      		</div>
                      	</div>
                      </section>
                      <!--<section>
                          <div class="row">
                              <div class="col-lg-6">
                                  <div class="panel">
                                      <div class="panel-body">
                                          <div class="bio-chart">
                                              <input class="knob" data-width="100" data-height="100" data-displayPrevious=true  data-thickness=".2" value="35" data-fgColor="#e06b7d" data-bgColor="#e8e8e8">
                                          </div>
                                          <div class="bio-desk">
                                              <h4 class="red">Envato Website</h4>
                                              <p>Started : 15 July</p>
                                              <p>Deadline : 15 August</p>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                              <div class="col-lg-6">
                                  <div class="panel">
                                      <div class="panel-body">
                                          <div class="bio-chart">
                                              <input class="knob" data-width="100" data-height="100" data-displayPrevious=true  data-thickness=".2" value="63" data-fgColor="#4CC5CD" data-bgColor="#e8e8e8">
                                          </div>
                                          <div class="bio-desk">
                                              <h4 class="terques">ThemeForest CMS </h4>
                                              <p>Started : 15 July</p>
                                              <p>Deadline : 15 August</p>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                              <div class="col-lg-6">
                                  <div class="panel">
                                      <div class="panel-body">
                                          <div class="bio-chart">
                                              <input class="knob" data-width="100" data-height="100" data-displayPrevious=true  data-thickness=".2" value="75" data-fgColor="#96be4b" data-bgColor="#e8e8e8">
                                          </div>
                                          <div class="bio-desk">
                                              <h4 class="green">VectorLab Portfolio</h4>
                                              <p>Started : 15 July</p>
                                              <p>Deadline : 15 August</p>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                              <div class="col-lg-6">
                                  <div class="panel">
                                      <div class="panel-body">
                                          <div class="bio-chart">
                                              <input class="knob" data-width="100" data-height="100" data-displayPrevious=true  data-thickness=".2" value="50" data-fgColor="#cba4db" data-bgColor="#e8e8e8">
                                          </div>
                                          <div class="bio-desk">
                                              <h4 class="purple">Adobe Muse Template</h4>
                                              <p>Started : 15 July</p>
                                              <p>Deadline : 15 August</p>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </section>-->
                  </aside>
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
				'library/js/ng/suppliers.services.js',
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