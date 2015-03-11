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
              <div class="row" ng-app="users" ng-controller="ShowController" ng-init="init({{ $user->employee->id; }}); getBySeller(); $root.generateUserPermissions({{ $user->role_id; }}); $root.generateAuthPermissions({{ \Auth::user()->role_id; }});">
                  <aside class="profile-nav col-lg-3">
                      <section class="panel">
                          <div class="user-heading round">
                              <a href="#">
                                  <img src="{{ asset('images_profile/'.$user->image_profile) }}" alt="">
                              </a>
                              <h1>{{ $user->username }}</h1>
                              <p>{{ $user->email }}</p>
                              <p>{{ $user->role->name }}</p>
                          </div>

                          <ul class="nav nav-pills nav-stacked">
                              <li ng-class="{'active' : tab == 'perfil' } "><a href="" ng-click="tab = 'perfil'" > <i class="fa fa-user"></i>Perfil</a></li>
                              <li ng-show="$root.auth_permissions.read.sale && $root.user_permissions.create.sale" ><a href="" ng-click="tab = 'ventas'" > <i class="fa fa-user"></i>Ventas</a></li>
                              <li ng-show="$root.auth_permissions.read.commission" ><a href="" ng-click="tab = 'comisiones'" > <i class="fa fa-user"></i>Comisiones</a></li>
                              <li ng-show="$root.auth_permissions.read.delivery && $root.user_permissions.create.delivery" ><a href="" ng-click="tab = 'entregas'" > <i class="fa fa-user"></i>Entregas</a></li>
                              <li ng-show="$root.auth_permissions.edit.user"><a href="profile-activity.html"> <i class="fa fa-calendar"></i>Actividad reciente</a></li>
                              <li><a href="{{ route('users.edit' , [ $user->id ]) }}"> <i class="fa fa-edit"></i> Editar usuario</a></li>
                          </ul>

                      </section>
                  </aside>
                  <aside class="profile-info col-lg-9">

                      @include('users.sections.profile')

                      @if( !empty($user->employee->sales) )

                        @include('users.sections.sales')

                      @endif

                      @if( !empty($user->employee->commissions) )

                        @include('users.sections.commissions')

                      @endif

                      @if( !empty($user->employee->deliveries) )

                        @include('users.sections.deliveries')

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
                  'library/js/ng/users.js',
                  'library/js/ng/users.controllers.js',
                  'library/js/ng/users.services.js',
                  'library/js/ng/sales.services.js',
                  'library/js/ng/users.filters.js',
                  'library/js/ng/commissions.filters.js',
                  'library/js/ng/users.directives.js',
                  'library/js/ng/ng-date.js',
                  'library/js/jquery-ui-1.9.2.custom.min.js' ,
    							'library/js/bootstrap-switch.js' ,
    							'library/js/jquery.tagsinput.js' ,
    							'library/js/ga.js' ,
    							]
    				   ]
    		)

@stop