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
              <div class="row" ng-app="suppliers" >
                  <aside class="profile-nav col-lg-3">
                      <section class="panel">
                          <div class="user-heading round">
                              <h1>{{ $supplier->name }}</h1>
                              <p>{{ $supplier->email }}</p>
                          </div>

                          <ul class="nav nav-pills nav-stacked">
                              <li class="active"><a href="profile.html"> <i class="fa fa-user"></i>Perfil</a></li>
                              <li><a href="profile-activity.html"> <i class="fa fa-calendar"></i>Actividad reciente</a></li>
                              <li><a href="{{ route('suppliers.edit' , [ $supplier->id ]) }}"> <i class="fa fa-edit"></i> Editar proveedor</a></li>
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

                      <section class="panel" ng-controller="SuppliersController">
                          <div class="panel-heading">
                              <h2>Datos personales. </h2>
                          </div>
                          <div class="panel-body bio-graph-info">
                              <div class="row">
                                  <div class="col-sm-6">
                                      <span class="col-sm-6">Nombre </span><p class="col-sm-6"> {{ $supplier->name }}</p>
                                  </div>
                                  <div class="col-sm-6">
                                      <span class="col-sm-6">Correo electrónico </span><p class="col-sm-6"> {{ $supplier->email }}</p>
                                  </div>
                                  <div class="col-sm-6">
                                      <span class="col-sm-6">Teléfono </span><p class="col-sm-6"> {{ $supplier->phone }}</p>
                                  </div>                                  
                                  <div class="col-sm-6">
                                      <span class="col-sm-6">RFC</span><p class="col-sm-6"> {{ $supplier->rfc }}</p>
                                  </div>
                                  <div class="col-sm-6">
                                      <span class="col-sm-6">Razón social</span><p class="col-sm-6"> {{ $supplier->business_name }}</p>
                                  </div>
                                  <div class="col-sm-6">
                                      <span class="col-sm-6">Calle</span><p class="col-sm-6"> {{ $supplier->street }}</p>
                                  </div>
                                  <div class="col-sm-6">
                                      <span class="col-sm-6">Número exterior</span><p class="col-sm-6"> {{ $supplier->outer_number }}</p>
                                  </div>
                                  <div class="col-sm-6">
                                      <span class="col-sm-6"> Número interior</span><p class="col-sm-6"> {{ $supplier->inner_number }}</p>
                                  </div>
                                  <div class="col-sm-6">
                                      <span class="col-sm-6">Código postal</span><p class="col-sm-6"> {{ $supplier->zip_code }}</p>
                                  </div>
                                  <div class="col-sm-6">
                                      <span class="col-sm-6">Colonia</span><p class="col-sm-6"> {{ $supplier->colony }}</p>
                                  </div>
                                  <div class="col-sm-6">
                                      <span class="col-sm-6">Delegación o municipio</span><p class="col-sm-6"> {{ $supplier->city }}</p>
                                  </div>
                                  <div class="col-sm-6">
                                      <span class="col-sm-6">Estado</span><p class="col-sm-6"> {{ $supplier->state }}</p>
                                  </div>
                                  <div class="col-sm-6">
                                      <span class="col-sm-6">Status </span><p class="col-sm-6"> {{ <?php echo $supplier->status ?>  | boolean }}</p>
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
                  'library/js/ng/suppliers.js',
                  'library/js/ng/suppliers.controllers.js',
                  'library/js/ng/suppliers.services.js',
                  'library/js/ng/suppliers.filters.js',
                  'library/js/ng/suppliers.directives.js',
                                'library/js/ng/directives.js',
                  'library/js/jquery-ui-1.9.2.custom.min.js' ,
    			  'library/js/bootstrap-switch.js' ,
    			  'library/js/jquery.tagsinput.js' ,
    			  'library/js/ga.js' ,
    							]
    				   ]
    		)

@stop