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
              <div class="row" ng-app="expenses" ng-controller="ExpensesController" ng-init="$root.generateAuthPermissions({{ Auth::user()->role_id }})">
                  <aside class="profile-nav col-lg-3">
                      <section class="panel">
                          <div class="user-heading round">
                              <h1>{{ $expense->expense_type->name }}</h1>
                              <p>{{ '<?php echo $expense->quantity ?>' | currency }}</p>
                          </div>

                          <ul class="nav nav-pills nav-stacked">
                              <!--<li class="active"><a href="profile.html"> <i class="fa fa-user"></i>Perfil</a></li>
                              <li><a href="profile-activity.html"> <i class="fa fa-calendar"></i>Actividad reciente</a></li>-->
                              <li ng-if="$root.auth_permissions.update.expense" ><a href="{{ route('expenses.edit' , [ $expense->id ]) }}"> <i class="fa fa-edit"></i> Editar gasto</a></li>
                          </ul>

                      </section>
                  </aside>
                  <aside class="profile-info col-lg-9">
                     

                      <section class="panel" >
                          <div class="panel-heading">
                              <h2>Detalle. </h2>
                          </div>
                          <div class="panel-body bio-graph-info">
                              <div class="row">
                                  <div class="col-sm-6">
                                      <span class="col-sm-6">Tipo </span><p class="col-sm-6"> {{ $expense->expense_type->name }}</p>
                                  </div>
                                  <div class="col-sm-6">
                                      <span class="col-sm-6">Cantidad</span><p class="col-sm-6"> {{ '<?php echo $expense->quantity ?>' | currency }}</p>
	                              </div>
                                  <div ng-if="$root.auth_permissions.read.user" class="col-sm-6">
                                      <span class="col-sm-6">Empleado </span><p class="col-sm-6"> {{ $expense->employee->user->name }}</p>
                                  </div>
                                  <div class="col-sm-6">
                                      <span class="col-sm-6">Fecha </span><p class="col-sm-6"> {{ $expense->date }}</p>
                                  </div>                                  
                                  <div class="col-sm-6">
                                      <span class="col-sm-6">Concepto</span><p class="col-sm-6"> {{ $expense->concept }}</p>
                                  </div>
                                  <div class="col-sm-6">
                                      <span class="col-sm-6">Descripción</span><p class="col-sm-6"> {{ $expense->description }}</p>
                                  </div>
	                          </div>
	                     </div>
                      </section>
                      
                  </aside>
              </div>

              <!-- page end-->
	
@stop

@section('sidebar_right')

    @include('sidebar_right')

@stop

@section('footer')

    @include('footer', ['js' => [
                  'library/js/ng/expenses.js',
                  'library/js/ng/expenses.controllers.js',
                  'library/js/ng/expenses.services.js',
                  'library/js/ng/users.services.js',
                  'library/js/ng/users.filters.js',
        		  'library/js/ng/ng-date.js',
                  'library/js/jquery-ui-1.9.2.custom.min.js' ,
    			  'library/js/bootstrap-switch.js' ,
    			  'library/js/jquery.tagsinput.js' ,
    			  'library/js/ga.js' ,
                  'library/assets/bootstrap-fileupload/bootstrap-fileupload.js'
    							]
    				   ]
    		)

@stop