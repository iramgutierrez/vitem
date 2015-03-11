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
              <div class="row" ng-app="clients" ng-controller="ShowController" ng-init="init({{ $client->id; }}); getByClient(); $root.generateAuthPermissions({{ \Auth::user()->role_id; }});">
                  <aside class="profile-nav col-lg-3">
                      <section class="panel">
                          <div class="user-heading round">
                              <a href="#">
                                  <img src="{{ asset('images_profile_clients/'.$client->image_profile) }}" alt="">
                              </a>
                              <h1>{{ $client->name }}</h1>
                              <p>{{ $client->email }}</p>
                          </div>

                          <ul class="nav nav-pills nav-stacked">
                              <li ng-class="{ active: tab== 'profile' }" ><a ng-click="tab = 'profile'"> <i class="fa fa-user"></i>Perfil</a></li>
                              <li ng-class="{ active: tab== 'ventas' }" ng-show="$root.auth_permissions.read.sale" ><a href="" ng-click="tab = 'ventas'" > <i class="fa fa-user"></i>Ventas</a></li>
                              <li ng-if="$root.auth_permissions.update.client" ><a href="{{ route('clients.edit' , [ $client->id ]) }}"> <i class="fa fa-edit"></i> Editar cliente</a></li>
                          </ul>

                      </section>
                  </aside>
                  <aside class="profile-info col-lg-9">

                     @include('clients.sections.profile')

                      @if( !empty($client->sale) )

                        @include('clients.sections.sales')

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
                  'library/js/ng/clients.js',
                  'library/js/ng/clients.controllers.js',
                  'library/js/ng/sales.services.js',
                  'library/js/ng/clients.services.js',
                  'library/js/ng/clients.filters.js',
                  'library/js/ng/clients.directives.js',
                                'library/js/ng/directives.js',
                  'library/js/ng/ng-date.js',
                  'library/js/jquery-ui-1.9.2.custom.min.js' ,
    							'library/js/bootstrap-switch.js' ,
    							'library/js/jquery.tagsinput.js' ,
    							'library/js/ga.js' ,
    							]
    				   ]
    		)

@stop