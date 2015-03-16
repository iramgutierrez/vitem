@extends('layout')

@section('header')

    @include('header' , [ 'css' => [
    								'library/assets/bootstrap-datepicker/css/datepicker.css',
    							   ]
    					]
    		)

@stop

@section('sidebar_left')

    @include('sidebar_left')

@stop

@section('content')




<div ng-app="users" >

<div class="adv-table" ng-controller="UsersController" ng-init="$root.generateAuthPermissions({{ \Auth::user()->role_id; }});">
<div class="panel">
    <div class="panel-body">
        <div ng-view></div>
        <header class="panel-heading col-sm-12">
            <h1 class="col-sm-3">Usuarios</h1>
            <a ng-if="$root.auth_permissions.create.user" href="{{ route('users.create') }}"><button type="button" class="pull-right btn btn-success ">Agregar usuario</button></a>
        </header>    
   
        {{ Field::text(
                '', 
                '' , 
                [ 
                    'class' => 'col-md-10' , 
                    'addon-first' => '<i class="fa fa-search"></i>' , 
                    'placeholder' => 'Busca por id, nombre, correo electrónico o nombre de usuario.',
                    'ng-model' => 'find',
                    'ng-change' => 'search()'

                ]
            ) 
        }}
        <hr>
        <div class="col-sm-12">
        <pagination></pagination>

        </div>
        <div class="btn-row col-sm-12 text-right">
            <label class="col-sm-12">Ver: </label>

                                  <div class="btn-group">
                                      <button type="button"     ng-click="viewGrid = 'list'" class="btn btn-info" ng-class="{'active': viewGrid == 'list'}">Lista</button>
                                      <button type="button" ng-click="viewGrid = 'details'" class="btn btn-info" ng-class="{'active': viewGrid == 'details'}">Detalle</button>
                                  </div>
                              </div>
        <div class="clearfix"></div>
        <hr>
        <div class="col-sm-12">
            <p class="col-sm-2"><span class="badge bg-success">@{{users.length}}</span> usuarios</p>        
            <button type="button" ng-click="clear()" class="pull-right btn btn-info">Limpiar filtros</button>
        </div>
        <div class="clearfix"></div>
        <hr>
        <table  class="display table table-bordered table-striped col-sm-12" id="dynamic-table" >
            <thead>
                <tr >
                    <th class="col-sm-1">                        
                        <a href="" ng-click="sort = 'id'; reverse=!reverse">Id
                            <span class="pull-right" >
                                <i class="fa fa-sort" ng-if="sort != 'id' "></i>
                                <i class="fa fa-sort-numeric-asc" ng-if=" sort == 'id' && reverse == false "></i>
                                <i class="fa  fa-sort-numeric-desc" ng-if=" sort == 'id' && reverse == true "></i>
                            </span>
                        </a>
                    </th>
                    <th class="col-sm-1">
                        <a href="" ng-click="sort = 'name'; reverse=!reverse">Nombre
                            <span class="pull-right" >
                                <i class="fa fa-sort" ng-if="sort != 'name' "></i>
                                <i class="fa fa-sort-alpha-asc" ng-if=" sort == 'name' && reverse == false "></i>
                                <i class="fa  fa-sort-alpha-desc" ng-if=" sort == 'name' && reverse == true "></i>
                            </span>
                        </a>
                    </th>
                    <th class="col-sm-1" ng-show="$root.auth_permissions.read.store" >
                            <a href="" ng-click="sort = 'store.name'; reverse=!reverse">Sucursal
                                <span class="pull-right" >
                                    <i class="fa fa-sort" ng-if="sort != 'store.name' "></i>
                                    <i class="fa fa-sort-alpha-asc" ng-if=" sort == 'store.name' && reverse == false "></i>
                                    <i class="fa  fa-sort-alpha-desc" ng-if=" sort == 'store.name' && reverse == true "></i>
                                </span>
                            </a>
                    </th>
                    <th class="col-sm-1">
                        <a href="" ng-click="sort = 'email'; reverse=!reverse">Correo electrónico
                            <span class="pull-right" >
                                <i class="fa fa-sort" ng-if="sort != 'email' "></i>
                                <i class="fa fa-sort-alpha-asc" ng-if=" sort == 'email' && reverse == false "></i>
                                <i class="fa  fa-sort-alpha-desc" ng-if=" sort == 'email' && reverse == true "></i>
                            </span>
                        </a>
                    </th>
                    <th class="col-sm-1">
                        <a href="" ng-click="sort = 'username'; reverse=!reverse">Usuario
                            <span class="pull-right" >
                                <i class="fa fa-sort" ng-if="sort != 'username' "></i>
                                <i class="fa fa-sort-alpha-asc" ng-if=" sort == 'username' && reverse == false "></i>
                                <i class="fa  fa-sort-alpha-desc" ng-if=" sort == 'username' && reverse == true "></i>
                            </span>
                        </a>
                    </th>
                    <th class="col-sm-1">
                        <a class="col-sm-12" href="" ng-click="sort = 'role.name'; reverse=!reverse">Tipo
                            <span class="pull-right" >
                                <i class="fa fa-sort" ng-if="sort != 'role.name'  && type == ''"></i>
                                <i class="fa fa-sort-alpha-asc" ng-if=" sort == 'role.name' && reverse == false && type == ''"></i>
                                <i class="fa  fa-sort-alpha-desc" ng-if=" sort == 'role.name' && reverse == true && type == ''"></i>
                            </span>
                        </a>
                    </th>
                    <th class="col-sm-2">
                        <a href="" ng-click="sort = 'employee.entry_date'; reverse=!reverse">Fecha de ingreso
                            <span class="pull-right" >
                                <i class="fa fa-sort" ng-if="sort != 'employee.entry_date' "></i>
                                <i class="fa fa-sort-numeric-asc" ng-if=" sort == 'employee.entry_date' && reverse == false "></i>
                                <i class="fa  fa-sort-numeric-desc" ng-if=" sort == 'employee.entry_date' && reverse == true "></i>
                            </span>
                        </a>
                    </th>
                    <th class="col-sm-2">
                        <a href="" ng-click="sort = 'employee.salary'; reverse=!reverse">Salario
                            <span class="pull-right" >
                                <i class="fa fa-sort" ng-if="sort != 'employee.salary' "></i>
                                <i class="fa fa-sort-numeric-asc" ng-if=" sort == 'employee.salary' && reverse == false "></i>
                                <i class="fa  fa-sort-numeric-desc" ng-if=" sort == 'employee.salary' && reverse == true "></i>
                            </span>
                        </a>
                    </th>
                    <!--<th class="col-sm-1">
                        <a class="col-sm-12" href="" ng-click="sort = 'status'; reverse=!reverse">Status
                            <span class="pull-right" >
                                <i class="fa fa-sort" ng-if="sort != 'status' "></i>
                                <i class="fa fa-sort-alpha-asc" ng-if=" sort == 'status' && reverse == false "></i>
                                <i class="fa  fa-sort-alpha-desc" ng-if=" sort == 'status' && reverse == true "></i>
                            </span>
                        </a>
                    </th>-->
                    <th class="col-sm-2"></th>
                    <!--<th class="hidden-phone">Nombre de usuario</th>
                    <th class="hidden-phone"></th>-->
                </tr>
                <tr>
                    <th></th>
                    <th></th>
                    <th ng-show="$root.auth_permissions.read.store"></th>
                    <th></th>
                    <th></th>
                    <th>
                        <span class="">
                            {{ Field::select(
                                                        '', 
                                                        $roles,
                                                        '' ,
                                                        [ 
                                                            'ng-model' => 'type',
                                                            'ng-change' => 'search()'
                                                        ]
                                                ) 
                                        }}
                        </span>
                    </th>
                    <th>
                        <span class="col-sm-12">
                            {{ Field::select(
                                                        '', 
                                                        $filtersEntryDate,
                                                        '' ,
                                                        [ 
                                                            'ng-model' => 'operatorEntryDate',
                                                            'ng-change' => 'search()'
                                                        ]
                                                ) 
                                        }}
                        </span>
                        <span class="col-sm-12">                                                      
                            {{ Field::text(
                                                        '', 
                                                        '' ,
                                                        [ 
                                                            'ui-date' => 'dateOptions',
                                                            'ui-date-format' => 'yy-mm-dd',
                                                            'ng-model' => 'entryDate ',
                                                            'ng-change' => 'search()'
                                                        ]
                                                ) 
                                        }}
                        </span>
                        
                    </th>

                    <th>
                        <span class="col-sm-12">
                            {{ Field::select(
                                                        '', 
                                                        $filtersSalary,
                                                        '' ,
                                                        [ 
                                                            'ng-model' => 'operatorSalary',
                                                            'ng-change' => 'search()'
                                                        ]
                                                ) 
                                        }}
                        </span>
                        <span class="col-sm-12">
                            {{ Field::text(
                                                        '', 
                                                        '' ,
                                                        [ 
                                                            'ng-model' => 'salary',
                                                            'ng-change' => 'search()',                                                    
                                                        ]
                                                ) 
                                        }}
                        </span>
                        
                    </th>
                    <!--<th>
                        <span class="">
                            {{ Field::select(
                                                        '', 
                                                        $statuses,
                                                        '' ,
                                                        [ 
                                                            'ng-model' => 'status',
                                                            'ng-change' => 'search()'
                                                        ]
                                                ) 
                                        }}
                        </span>
                    </th>-->
                    <th></th>
                </tr>
            </thead>
            <tbody ng-if="viewGrid == 'list'" >
                <tr class="gradeX" ng-repeat="user in usersP | orderBy:sort:reverse">
                    <td>@{{ user.id }}</td>
                    <td>@{{ user.name }}</td>
                    <td ng-show="$root.auth_permissions.read.store">@{{ user.store.name }}</td>
                    <td>@{{ user.email }}</td>
                    <td>@{{ user.username }}</td>
                    <td>@{{ user.role.name }}</td>
                    <td>@{{ user.employee.entry_date }}</td>
                    <td>@{{ user.employee.salary | currency }}</td>
                    <!--<td>@{{ user.status | boolean}}</td>-->
                    <td>
                        <a href="@{{ user.url_show }}" ng-show="$root.auth_permissions.read.user">
                            <button type="button" class="col-sm-3 btn btn-success"><i class="fa fa-eye"></i></button>
                        </a>
                        <a href="@{{ user.url_edit }}" ng-show="$root.auth_permissions.update.user">
                            <button  type="button" class="col-sm-3 col-sm-offset-1 btn btn-info "><i class="fa fa-refresh"></i></button>
                        </a>
                        <a data-toggle="modal" href="#myModal@{{user.id}}" ng-show="$root.auth_permissions.delete.user">
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
        </div> 

        <div class="panel" ng-if="suppliersP.length == 0">
            <div class="panel-body">
                <h3 class="text-center">No se encontraron usuarios.</h3>
            </div>
        </div>

        <div class="directory-info-row" ng-if="viewGrid == 'details'">
              <div class="row">
              <div class="col-md-6 col-sm-6 clearfix"  ng-repeat="user in usersP | orderBy:sort:reverse">
                  <div class="panel">
                      <div class="panel-body">
                          <div class="media">
                              <a class="pull-left" href="@{{ user.url_show }}">
                                  <img class="img-responsive thumb media-object" src="@{{ user.image_profile_url }}" alt="">
                              </a>
                              <div class="media-body">
                                  <h4> @{{ user.name }} <span class="text-muted small"> - @{{ user.role.name }}</span></h4>
                                  <strong>@{{ user.username }}</strong><br>
                                  <address>
                                      
                                      <strong>@{{ user.email }}</strong><br>
                                        &nbsp;@{{ user.address }}<br>                                      
                                      <span>&nbsp;<abbr title="Phone" ng-if="user.phone">P:</span> @{{ user.phone }}
                                  </address>
                                  @{{ user.employee.salary | currency }}<br>
                                  <div class="col-sm-6 pull-right">

                                  <a href="@{{ user.url_show }}" class="col-sm-4" ng-if="$root.auth_permissions.read.user">
                            <button type="button" class=" btn btn-success"><i class="fa fa-eye"></i></button>
                        </a>
                        <a href="@{{ user.url_edit }}" class="col-sm-4" ng-if="$root.auth_permissions.update.user">
                            <button  type="button" class="col-sm-offset-1 btn btn-info "><i class="fa fa-refresh"></i></button>
                        </a>
                        <a data-toggle="modal" href="#myModalD@{{user.id}}" class="col-sm-4" ng-if="$root.auth_permissions.delete.user" >
                            <button type="button" class="col-sm-offset-1 btn btn-danger"><i class="fa fa-trash-o"></i></button>    
                        </a>
                              <div class="modal fade" id="myModalD@{{user.id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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


                              </div>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>            

              </div>
              </div>  

    </div>
</div>

	
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