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
              <div class="row" ng-app="suppliers" ng-controller="ShowController" ng-init="$root.generateAuthPermissions({{ \Auth::user()->role_id; }})">
                  <aside class="profile-nav col-lg-3">
                      <section class="panel">
                          <div class="user-heading round">
                              <h1>{{ $supplier->name }}</h1>
                              <p>{{ $supplier->email }}</p>
                          </div>

                          <ul class="nav nav-pills nav-stacked">
                              <li ng-class="{active : tab == 'profile' }"><a ng-click="tab = 'profile'"> <i class="fa fa-user"></i>Perfil</a></li>
                              <li ng-class="{active : tab == 'products' }" ng-show="$root.auth_permissions.read.product" ><a href="" ng-click="tab = 'products'" > <i class="fa fa-calendar"></i>Productos</a></li>
                              <li ng-if="$root.auth_permissions.update.supplier" ><a href="{{ route('suppliers.edit' , [ $supplier->id ]) }}"> <i class="fa fa-edit"></i> Editar proveedor</a></li>
                          </ul>

                      </section>
                  </aside>
                  <aside class="profile-info col-lg-9">

                      @include('suppliers.sections.profile')

                      @if(!empty($supplier->products))

                        @include('suppliers.sections.products')

                      @endif
                     

                      
                      
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
                  'library/js/ng/products.services.js',
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