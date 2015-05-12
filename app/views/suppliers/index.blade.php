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
<div   ng-app="suppliers" >
<div class="adv-table" ng-controller="SuppliersController" ng-init="$root.generateAuthPermissions({{ \Auth::user()->role_id }}); ">
<div class="panel">
    <div class="panel-body">
        <div ng-view></div>
        <header class="panel-heading col-sm-12">
            <h1 class="col-sm-3">Proveedores</h1>
            <a ng-if="$root.auth_permissions.create.supplier" href="{{ route('suppliers.create') }}"><button type="button" class="pull-right btn btn-success ">Agregar proveedor</button></a>
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
            <p class="col-sm-2"><span class="badge bg-success">@{{suppliers.length}}</span> proveedores</p>        
            <button type="button" ng-click="clear()" class="pull-right btn btn-info">Limpiar filtros</button>
        </div>

        @if(Auth::user()->role->level_id >= 3)
        
        <!-- Generar XLS -->
        
        <div class="clearfix"></div>

        <hr>

        {{ Form::open(['route' => 'reports.generate_custom_xls' ,'class' => 'col-sm-12']) }}

            {{

                Field::hidden(
                    'headersExport',
                    '',
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

            <button type="submit" class="pull-right btn btn-success" ng-disabled="!dataExport">Generar XLS</button>

        {{ Form::close() }}

        <!-- Generar XLS -->

        @endif
        
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
                    <!--<th class="hidden-phone">Nombre de proveedor</th>
                    <th class="hidden-phone"></th>-->
                </tr>
                <!--<tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th>
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
                    </th>
                    <th></th>
                </tr>-->
            </thead>
            <tbody ng-if="viewGrid == 'list'" >
                <tr class="gradeX" ng-repeat="supplier in suppliersP | orderBy:sort:reverse">
                    <td>@{{ supplier.id }}</td>
                    <td>@{{ supplier.name }}</td>
                    <td>@{{ supplier.email }}</td>
                    <!--<td>@{{ supplier.status | boolean }}</td>-->
                    <td>
                        <a href="@{{ supplier.url_show }}" ng-if="$root.auth_permissions.read.supplier " >
                            <button type="button" class="col-sm-3 btn btn-success"><i class="fa fa-eye"></i></button>
                        </a>
                        <a href="@{{ supplier.url_edit }}" ng-if="$root.auth_permissions.update.supplier " >
                            <button  type="button" class="col-sm-3 col-sm-offset-1 btn btn-info "><i class="fa fa-refresh"></i></button>
                        </a>
                        <a data-toggle="modal" href="#myModal@{{supplier.id}}" ng-if="$root.auth_permissions.delete.supplier " >
                            <button type="button" class="col-sm-3 col-sm-offset-1 btn btn-danger"><i class="fa fa-trash-o"></i></button>    
                        </a>
                              <div ng-if="$root.auth_permissions.delete.supplier " class="modal fade" id="myModal@{{supplier.id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                  <div class="modal-dialog">
                                      <div class="modal-content">
                                          <div class="modal-header">
                                              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                              <h4 class="modal-title">Confirma</h4>
                                          </div>
                                          <div class="modal-body">

                                              ¿Deseas eliminar el proveedor <strong>@{{supplier.name}}</strong>?

                                          </div>
                                          <div class="modal-footer">
                                              <button data-dismiss="modal" class="btn btn-default" type="button">Regresar</button>                                              
                                                <form class="btn " method="POST" action = "@{{ supplier.url_delete }}">
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
				<h3 class="text-center">No se encontraron proveedores.</h3>
        	</div>
        </div>

        <div class="directory-info-row" ng-if="viewGrid == 'details'">
              <div class="row">
              <div class="col-md-6 col-sm-6 clearfix"  ng-repeat="supplier in suppliersP | orderBy:sort:reverse">
                  <div class="panel">
                      <div class="panel-body">
                          <div class="media">
                              <a class="pull-left" href="@{{ supplier.url_show }}">
                                  <img class="thumb media-object" src="@{{ supplier.image_profile_url }}" alt="">
                              </a>
                              <div class="media-body">
                                  <h4> @{{ supplier.name }} </h4>
                                  <!--<ul class="social-links">
                                      <li><a title="" data-placement="top" data-toggle="tooltip" class="tooltips" href="" data-original-title="Facebook"><i class="fa fa-facebook"></i></a></li>
                                      <li><a title="" data-placement="top" data-toggle="tooltip" class="tooltips" href="" data-original-title="Twitter"><i class="fa fa-twitter"></i></a></li>
                                      <li><a title="" data-placement="top" data-toggle="tooltip" class="tooltips" href="" data-original-title="LinkedIn"><i class="fa fa-linkedin"></i></a></li>
                                      <li><a title="" data-placement="top" data-toggle="tooltip" class="tooltips" href="" data-original-title="Skype"><i class="fa fa-skype"></i></a></li>
                                  </ul><br>-->
                                  <address>
                                      
                                      <strong>@{{ supplier.email }}</strong><br>
                                        &nbsp;@{{ supplier.address }}<br>                                      
                                      <span>&nbsp;<abbr title="Phone" ng-if="supplier.phone">P:</span> @{{ supplier.phone }}
                                  </address>
                                  <div class="col-sm-6 pull-right">

                                  <a ng-if="$root.auth_permissions.read.supplier " href="@{{ supplier.url_show }}" class="col-sm-4" >
                            <button type="button" class=" btn btn-success"><i class="fa fa-eye"></i></button>
                        </a>
                        <a ng-if="$root.auth_permissions.update.supplier " href="@{{ supplier.url_edit }}" class="col-sm-4" >
                            <button  type="button" class="col-sm-offset-1 btn btn-info "><i class="fa fa-refresh"></i></button>
                        </a>
                        <a ng-if="$root.auth_permissions.delete.supplier " data-toggle="modal" href="#myModalD@{{supplier.id}}" class="col-sm-4" >
                            <button type="button" class="col-sm-offset-1 btn btn-danger"><i class="fa fa-trash-o"></i></button>    
                        </a>
                              <div ng-if="$root.auth_permissions.delete.supplier " class="modal fade" id="myModalD@{{supplier.id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                  <div class="modal-dialog">
                                      <div class="modal-content">
                                          <div class="modal-header">
                                              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                              <h4 class="modal-title">Confirma</h4>
                                          </div>
                                          <div class="modal-body">

                                              ¿Deseas eliminar el proveedor <strong>@{{supplier.name}}</strong>?

                                          </div>
                                          <div class="modal-footer">
                                              <button data-dismiss="modal" class="btn btn-default" type="button">Regresar</button>                                              
                                                <form class="btn " method="POST" action = "@{{ supplier.url_delete }}">
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