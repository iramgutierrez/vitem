@extends('layout')

@section('header')

    @include('header' , [ 'css' => []
    					]
    		)

@stop

@section('sidebar_left')

    @include('sidebar_left')

@stop

@section('content')
<div   ng-app="deliveries" >
<div class="adv-table" ng-controller="DeliveriesController" ng-init="$root.generateAuthPermissions({{ Auth::user()->role_id }})" >
<div class="panel">
    <div class="panel-body">
        <div ng-view></div>
        <header class="panel-heading col-sm-12">
            <h1 class="col-sm-3">Entregas</h1>
            <a ng-if="$root.auth_permissions.create.delivery" href="{{ route('deliveries.create') }}"><button type="button" class="pull-right btn btn-success ">Agregar entrega</button></a>
        </header>
    
   
        {{ Field::text(
                '', 
                '' , 
                [ 
                    'class' => 'col-md-10' , 
                    'addon-first' => '<i class="fa fa-search"></i>' , 
                    'placeholder' => 'Busca por id, folio de venta o chofer',
                    'ng-model' => 'find',
                    'ng-change' => 'search()'

                ]
            ) 
        }}
        <hr>
        <div class="col-sm-12">
        <pagination></pagination>

        </div>
        <div class="clearfix"></div>
        <hr>
        <div class="col-sm-12">
            <p class="col-sm-2"><span class="badge bg-success">@{{deliveries.length}}</span> entregas</p>        
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
                        <a href="" ng-click="sort = 'destination.type'; reverse=!reverse">Destino
                            <span class="pull-right" >
                                <i class="fa fa-sort" ng-if="sort != 'destination.type' "></i>
                                <i class="fa fa-sort-alpha-asc" ng-if=" sort == 'destination.type' && reverse == false "></i>
                                <i class="fa  fa-sort-alpha-desc" ng-if=" sort == 'destination.type' && reverse == true "></i>
                            </span>
                        </a>
                    </th>
                    <th class="col-sm-1">
                        <a href="" ng-click="sort = 'address'; reverse=!reverse">Dirección
                            <span class="pull-right" >
                                <i class="fa fa-sort" ng-if="sort != 'address' "></i>
                                <i class="fa fa-sort-alpha-asc" ng-if=" sort == 'address' && reverse == false "></i>
                                <i class="fa  fa-sort-alpha-desc" ng-if=" sort == 'address' && reverse == true "></i>
                            </span>
                        </a>
                    </th>
                    <th class="col-sm-2">
                        <a href="" ng-click="sort = 'sale.sheet'; reverse=!reverse">Folio de venta
                            <span class="pull-right" >
                                <i class="fa fa-sort" ng-if="sort != 'sale.sheet' "></i>
                                <i class="fa fa-sort-alpha-asc" ng-if=" sort == 'sale.sheet' && reverse == false "></i>
                                <i class="fa  fa-sort-alpha-desc" ng-if=" sort == 'sale.sheet' && reverse == true "></i>
                            </span>
                        </a>
                    </th>
                    <th class="col-sm-2">
                        <a href="" ng-click="sort = 'delivery_date'; reverse=!reverse">Fecha de entrega
                            <span class="pull-right" >
                                <i class="fa fa-sort" ng-if="sort != 'delivery_date' "></i>
                                <i class="fa fa-sort-alpha-asc" ng-if=" sort == 'delivery_date' && reverse == false "></i>
                                <i class="fa  fa-sort-alpha-desc" ng-if=" sort == 'delivery_date' && reverse == true "></i>
                            </span>
                        </a>
                    </th>
                    <th class="col-sm-2">
                        <a href="" ng-click="sort = 'employee.user.name'; reverse=!reverse">Chofer
                            <span class="pull-right" >
                                <i class="fa fa-sort" ng-if="sort != 'employee.user.name' "></i>
                                <i class="fa fa-sort-alpha-asc" ng-if=" sort == 'employee.user.name' && reverse == false "></i>
                                <i class="fa  fa-sort-alpha-desc" ng-if=" sort == 'employee.user.name' && reverse == true "></i>
                            </span>
                        </a>
                    </th>
                    <th class="col-sm-2"></th>
                    <!--<th class="hidden-phone">Nombre de destino</th>
                    <th class="hidden-phone"></th>-->
                </tr>
                <tr>
                    <th></th>
                    <th></th>
                    <th>
                        <span class="">
                            
                        </span>
                    </th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody >
                <tr class="gradeX" ng-repeat="delivery in deliveriesP | orderBy:sort:reverse">
                    <td>@{{ delivery.id }}</td>
                    <td>@{{ delivery.destination.type | destination_types }}: @{{ delivery.destination.value_type }}</td>
                    <td>@{{ delivery.address }}</td>
                    <td>@{{ delivery.sale.sheet }}</td>
                    <td>@{{ delivery.delivery_date }}</td>
                    <td>@{{ delivery.employee.user.name }}</td>
                    <td>
                        {{--<a href="@{{ delivery.url_show }}" ng-if="$root.auth_permissions.read.delivery">
                            <button type="button" class="col-sm-3 btn btn-success"><i class="fa fa-eye"></i></button>
                        </a>--}}
                        <a href="@{{ delivery.url_edit }}" ng-if="$root.auth_permissions.update.delivery" >
                            <button  type="button" class="col-sm-3 col-sm-offset-1 btn btn-info "><i class="fa fa-refresh"></i></button>
                        </a>
                        <a data-toggle="modal" href="#myModal@{{delivery.id}}" ng-if="$root.auth_permissions.delete.delivery">
                            <button type="button" class="col-sm-3 col-sm-offset-1 btn btn-danger"><i class="fa fa-trash-o"></i></button>    
                        </a>
                              <div ng-if="$root.auth_permissions.delete.delivery" class="modal fade" id="myModal@{{delivery.id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                  <div class="modal-dialog">
                                      <div class="modal-content">
                                          <div class="modal-header">
                                              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                              <h4 class="modal-title">Confirma</h4>
                                          </div>
                                          <div class="modal-body">

                                              ¿Deseas eliminar la entrega <strong>@{{delivery.id}}</strong>?

                                          </div>
                                          <div class="modal-footer">
                                              <button data-dismiss="modal" class="btn btn-default" type="button">Regresar</button>                                              
                                                <form class="btn " method="POST" action = "@{{ delivery.url_delete }}">
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

        <div class="panel" ng-if="deliveryP.length == 0">
        	<div class="panel-body">
				<h3 class="text-center">No se encontraron entregas.</h3>
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
        'library/js/ng/deliveries.js',
        'library/js/ng/deliveries.controllers.js',
        'library/js/ng/deliveries.services.js',
        'library/js/ng/destinations.services.js',
        'library/js/ng/destinations.filters.js',
        'library/js/ng/sales.services.js',
        'library/js/ng/users.services.js',
        'library/js/ng/users.filters.js',
        'library/js/ng/directives.js',
        'library/js/ng/ng-date.js',
        'library/js/jquery-ui-1.9.2.custom.min.js' ,
        'library/assets/bootstrap-fileupload/bootstrap-fileupload.js'
]
]
)

@stop