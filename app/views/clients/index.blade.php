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
<div   ng-app="clients" >
<div class="adv-table" ng-controller="ClientsController" ng-init="$root.generateAuthPermissions({{ \Auth::user()->role_id; }});">
<div class="panel">
    <div class="panel-body">
        <div ng-view></div>
        <header class="panel-heading col-sm-12">
            <h1 class="col-sm-3">Clientes</h1>
            <a ng-if="$root.auth_permissions.create.client" href="{{ route('clients.create') }}"><button type="button" class="pull-right btn btn-success ">Agregar cliente</button></a>
        </header>
    
   
        {{ Field::text(
                '', 
                '' , 
                [ 
                    'class' => 'col-md-10' , 
                    'addon-first' => '<i class="fa fa-search"></i>' , 
                    'placeholder' => 'Busca por id, nombre o correo electrónico.',
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
            <p class="col-sm-2"><span class="badge bg-success">@{{clients.length}}</span> clientes</p>        
            <button type="button" ng-click="clear()" class="pull-right btn btn-info">Limpiar filtros</button>
        </div>

        <!-- Generar XLS -->
        
        <div class="clearfix"></div>

        <hr>

        {{ Form::open(['route' => 'reports.generate_custom_xls' ,'class' => 'col-sm-12']) }}

            {{

                Field::hidden(
                    'headersExport',
                    null,
                    [
                        'ng-model' => 'headersExport',
                        'ng-value' => 'headersExport'
                    ]
                )

            }} 

            {{

                Field::hidden(
                    'dataExport',
                    null,
                    [
                        'ng-model' => 'dataExport',
                        'ng-value' => 'dataExport',
                        'ng-init' => 'generateJSONDataExport()',
                        'ng-change' => 'dataExport = generateJSONDataExport()'
                    ]
                )

            }}

            {{

                Field::hidden(
                    'filename',
                    null,
                    [
                        'ng-model' => 'filename',
                        'ng-value' => 'filename'
                    ]
                )

            }}

            <button type="submit" class="pull-right btn btn-success">Generar XLS</button>

        {{ Form::close() }}

        <!-- Generar XLS -->
        <div class="clearfix"></div>
        <hr>
        <table  class="display table table-bordered table-striped col-sm-12" id="dynamic-table" >
            <thead>
                <tr >
                    <th class="col-sm-1">                        
                        <a href="" ng-click="sort = 'id'; reverse=!reverse">Id
                            <span class="pull-right" >
                                <i class="fa fa-sort" ng-if="sort != 'id' "></i>
                                <i class="fa fa-sort-alpha-asc" ng-if=" sort == 'id' && reverse == false "></i>
                                <i class="fa  fa-sort-alpha-desc" ng-if=" sort == 'id' && reverse == true "></i>
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
                    <th class="col-sm-2">
                        <a href="" ng-click="sort = 'email'; reverse=!reverse">Correo electrónico
                            <span class="pull-right" >
                                <i class="fa fa-sort" ng-if="sort != 'email' "></i>
                                <i class="fa fa-sort-alpha-asc" ng-if=" sort == 'email' && reverse == false "></i>
                                <i class="fa  fa-sort-alpha-desc" ng-if=" sort == 'email' && reverse == true "></i>
                            </span>
                        </a>
                    </th>
                    <th class="col-sm-2">
                        <a href="" ng-click="sort = 'client_type.name'; reverse=!reverse">Tipo de cliente
                            <span class="pull-right" >
                                <i class="fa fa-sort" ng-if="sort != 'client_type.name' "></i>
                                <i class="fa fa-sort-alpha-asc" ng-if=" sort == 'client_type.name' && reverse == false "></i>
                                <i class="fa  fa-sort-alpha-desc" ng-if=" sort == 'client_type.name' && reverse == true "></i>
                            </span>
                        </a>
                    </th>
                    <th class="col-sm-2">
                        <a href="" ng-click="sort = 'entry_date'; reverse=!reverse">Fecha de ingreso
                            <span class="pull-right" >
                                <i class="fa fa-sort" ng-if="sort != 'entry_date' "></i>
                                <i class="fa fa-sort-numeric-asc" ng-if=" sort == 'entry_date' && reverse == false "></i>
                                <i class="fa  fa-sort-numeric-desc" ng-if=" sort == 'entry_date' && reverse == true "></i>
                            </span>
                        </a>
                    </th>
                    <!--<th class="col-sm-2">
                        <a href="" ng-click="sort = 'status'; reverse=!reverse">Status
                            <span class="pull-right" >
                                <i class="fa fa-sort" ng-if="sort != 'status' "></i>
                                <i class="fa fa-sort-alpha-asc" ng-if=" sort == 'status' && reverse == false "></i>
                                <i class="fa  fa-sort-alpha-desc" ng-if=" sort == 'status' && reverse == true "></i>
                            </span>
                        </a>
                    </th>-->
                    <th class="col-sm-2"></th>
                    <!--<th class="hidden-phone">Nombre de cliente</th>
                    <th class="hidden-phone"></th>-->
                </tr>
                <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th>
                        <span class="">
                            {{ Field::select(
                                                        '', 
                                                        $client_types,
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
                <tr class="gradeX" ng-repeat="client in clientsP | orderBy:sort:reverse">
                    <td>@{{ client.id }}</td>
                    <td>@{{ client.name }}</td>
                    <td>@{{ client.email }}</td>
                    <td>@{{ client.client_type.name }}</td>
                    <td>@{{ client.entry_date }}</td>
                    <!--<td>@{{ client.status | boolean }}</td>-->
                    <td>
                        <a href="@{{ client.url_show }}" ng-if="$root.auth_permissions.read.client">
                            <button type="button" class="col-sm-3 btn btn-success"><i class="fa fa-eye"></i></button>
                        </a>
                        <a href="@{{ client.url_edit }}" ng-if="$root.auth_permissions.update.client">
                            <button  type="button" class="col-sm-3 col-sm-offset-1 btn btn-info "><i class="fa fa-refresh"></i></button>
                        </a>
                        <a data-toggle="modal" href="#myModal@{{client.id}}" ng-if="$root.auth_permissions.delete.client">
                            <button type="button" class="col-sm-3 col-sm-offset-1 btn btn-danger"><i class="fa fa-trash-o"></i></button>    
                        </a>
                              <div ng-if="$root.auth_permissions.delete.client" class="modal fade" id="myModal@{{client.id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                  <div class="modal-dialog">
                                      <div class="modal-content">
                                          <div class="modal-header">
                                              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                              <h4 class="modal-title">Confirma</h4>
                                          </div>
                                          <div class="modal-body">

                                              ¿Deseas eliminar el cliente <strong>@{{client.name}}</strong>?

                                          </div>
                                          <div class="modal-footer">
                                              <button data-dismiss="modal" class="btn btn-default" type="button">Regresar</button>                                              
                                                <form class="btn " method="POST" action = "@{{ client.url_delete }}">
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
        <h3 class="text-center">No se encontraron clientes.</h3>
          </div>
        </div>

        <div class="directory-info-row" ng-if="viewGrid == 'details'">
              <div class="row">
              <div class="col-md-6 col-sm-6 clearfix"  ng-repeat="client in clientsP | orderBy:sort:reverse">
                  <div class="panel">
                      <div class="panel-body">
                          <div class="media">
                              <a class="pull-left" href="@{{ client.url_show }}">
                                  <img class="thumb media-object" src="@{{ client.image_profile_url }}" alt="">
                              </a>
                              <div class="media-body">
                                  <h4> @{{ client.name }} <span class="text-muted small"> - @{{ client.client_type.name }}</span></h4>
                                  <!--<ul class="social-links">
                                      <li><a title="" data-placement="top" data-toggle="tooltip" class="tooltips" href="" data-original-title="Facebook"><i class="fa fa-facebook"></i></a></li>
                                      <li><a title="" data-placement="top" data-toggle="tooltip" class="tooltips" href="" data-original-title="Twitter"><i class="fa fa-twitter"></i></a></li>
                                      <li><a title="" data-placement="top" data-toggle="tooltip" class="tooltips" href="" data-original-title="LinkedIn"><i class="fa fa-linkedin"></i></a></li>
                                      <li><a title="" data-placement="top" data-toggle="tooltip" class="tooltips" href="" data-original-title="Skype"><i class="fa fa-skype"></i></a></li>
                                  </ul><br>-->
                                  <address>
                                      
                                      <strong>@{{ client.email }}</strong><br>
                                        &nbsp;@{{ client.address }}<br>                                      
                                      <span>&nbsp;<abbr title="Phone" ng-if="client.phone">P:</span> @{{ client.phone }}
                                  </address>
                                  <div class="col-sm-6 pull-right">

                                  <a href="@{{ client.url_show }}" class="col-sm-4" ng-if="$root.auth_permissions.read.client">
                                    <button type="button" class=" btn btn-success"><i class="fa fa-eye"></i></button>
                                </a>
                                <a href="@{{ client.url_edit }}" class="col-sm-4" ng-if="$root.auth_permissions.update.client">
                                    <button  type="button" class="col-sm-offset-1 btn btn-info "><i class="fa fa-refresh"></i></button>
                                </a>
                                <a data-toggle="modal" href="#myModalD@{{client.id}}" class="col-sm-4" ng-if="$root.auth_permissions.delete.client">
                                    <button type="button" class="col-sm-offset-1 btn btn-danger"><i class="fa fa-trash-o"></i></button>    
                                </a>
                              <div class="modal fade" id="myModalD@{{client.id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                  <div class="modal-dialog">
                                      <div class="modal-content">
                                          <div class="modal-header">
                                              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                              <h4 class="modal-title">Confirma</h4>
                                          </div>
                                          <div class="modal-body">

                                              ¿Deseas eliminar el cliente <strong>@{{client.name}}</strong>?

                                          </div>
                                          <div class="modal-footer">
                                              <button data-dismiss="modal" class="btn btn-default" type="button">Regresar</button>                                              
                                                <form class="btn " method="POST" action = "@{{ client.url_delete }}">
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