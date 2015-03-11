@extends('layout')

@section('header')

     @include('header' , [ 'css' => [
                    				'library/css/bootstrap-switch.css'
    							   ]
    					]
    		)

@stop

@section('sidebar_left')

    @include('sidebar_left')

@stop

@section('content')

<!-- page start-->
              <div class="row" ng-app="roles" ng-controller="ShowController" ng-init="getRole({{ $role->id }})">
                  <aside class="profile-nav col-lg-3">
                      <section class="panel">
                          <div class="user-heading round">
                              <h1>@{{ role.name }}</h1>
                          </div>

                          <ul class="nav nav-pills nav-stacked">
                          	  <li><a ng-click="tab = 'permisos'" href=""> <i class="fa fa-edit"></i> Permisos</a></li>
                          	  <li><a ng-click="tab = 'usuarios'" href=""> <i class="fa fa-edit"></i> Usuarios</a></li>
                              <li><a href="@{{ role.url_edit }}"> <i class="fa fa-edit"></i> Editar rol</a></li>
                          </ul>

                      </section>
                  </aside>
                  <aside class="profile-info col-lg-9">

                      <section class="panel" ng-show="tab == 'permisos'">
                          <div class="panel-heading">
                              <h2>Permisos. </h2>
                          </div>
                          <div class="panel-body bio-graph-info">

                          	<table  class="display table table-bordered table-striped col-sm-12" id="dynamic-table" >
					            <thead>
					                <tr>
					                    <th class="col-sm-1"> 
					                    </th>
					                    <th ng-repeat="action in actions" >

					                    	@{{ action.spanish_name }}

					                    </th>
					                </tr>
					            </thead>
					            <tbody>

					            	<tr ng-repeat="entity in entities" style="vertical-align: top; ">

					            		<th>

					            			@{{ entity.spanish_name }}

					            		</th>
					            		<td ng-repeat="action in actions" class="text-center" > 

					            			<span ng-if="checkPermission(role.permission , entity.id , action.id)" >

					                    			<i class="fa fa-check-circle"></i>

					                    	</span>

					            		</td>

					            	</tr>

					            </tbody>
					        </table> 
                          </div>
                      </section>

                      <section class="panel" ng-show="tab == 'usuarios'">

                          <div class="panel-heading">
                              <h2>Usuarios. </h2>
                          </div>
                          <div class="panel-body bio-graph-info">

                          	<table  class="display table table-bordered table-striped col-sm-12" id="dynamic-table" >
					            <thead>
					                <tr >
					                    <th class="col-sm-1">                        
					                        Id
					                    </th>
					                    <th class="col-sm-1">
					                    	Nombre
					                    </th>
					                    <th class="col-sm-1">
					                        Correo electrónico
					                    </th>
					                    <th class="col-sm-1">
					                        Usuario
					                    </th>
					                    <th class="col-sm-2">
					                        Fecha de ingreso					                           
					                    </th>
					                    <th class="col-sm-2">
					                        Salario					                           
					                    </th>
					                    <th class="col-sm-1">
					                        Status
					                           
					                    </th>
					                    <th class="col-sm-2"></th>
					                </tr>					                
					            </thead>
					            <tbody>
					                <tr class="gradeX" ng-repeat="user in role.user">
					                    <td>@{{ user.id }}</td>
					                    <td>@{{ user.name }}</td>
					                    <td>@{{ user.email }}</td>
					                    <td>@{{ user.username }}</td>
					                    <td>@{{ user.employee.entry_date }}</td>
					                    <td>@{{ user.employee.salary | currency }}</td>
					                    <td>@{{ user.status | boolean}}</td>
					                    <td>
					                        <a href="@{{ user.url_show }}" >
					                            <button type="button" class="col-sm-3 btn btn-success"><i class="fa fa-eye"></i></button>
					                        </a>
					                        <a href="@{{ user.url_edit }}" >
					                            <button  type="button" class="col-sm-3 col-sm-offset-1 btn btn-info "><i class="fa fa-refresh"></i></button>
					                        </a>
					                        <a data-toggle="modal" href="#myModal@{{user.id}}" >
					                            <button type="button" class="col-sm-3 col-sm-offset-1 btn btn-danger"><i class="fa fa-trash-o"></i></button>    
					                        </a>
					                              <div class="modal fade" id="myModal@{{user.id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					                                  <div class="modal-dialog">
					                                      <div class="modal-content">
					                                          <div class="modal-header">
					                                              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					                                              <h4 class="modal-title">Confirma</h4>
					                                          </div>
					                                          <div class="modal-body">

					                                              ¿Deseas eliminar el usuario <strong>@{{user.username}}</strong>?

					                                          </div>
					                                          <div class="modal-footer">
					                                              <button data-dismiss="modal" class="btn btn-default" type="button">Regresar</button>                                              
					                                                <form class="btn " method="POST" action = "@{{ user.url_delete }}">
					                                                    <input name="_method" type="hidden" value="DELETE">
					                                                    {{  Form::token() }}
					                                                    <button type="submit" class="btn btn-danger"><i class="fa fa-trash-o"></i>Confirmar</button>    
					                                                </form>
					                                      </div>
					                                  </div>
					                              </div>
					                              </div>

					                    </td>
					                </tr>              
					            </tbody>
					        </table>    
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
                  				'library/js/jquery-ui-1.9.2.custom.min.js' ,
                                'library/js/ng/roles.js',
                                'library/js/ng/roles.controllers.js',
                                'library/js/ng/roles.services.js',
                                'library/js/ng/users.filters.js',
                                'library/js/ng/users.directives.js'
    							]
    				   ]
    		)

@stop