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
<div   ng-app="commissions" >
<div class="adv-table" ng-controller="CommissionsController" ng-init="$root.generateAuthPermissions({{ Auth::user()->role_id }})" >
<div class="panel">
    <div class="panel-body">
        <div ng-view></div>
        <header class="panel-heading col-sm-12">
            <h1 class="col-sm-3">Comisiones</h1>
            <a ng-if="$root.auth_permissions.create.commission" href="{{ route('commissions.create') }}"><button type="button" class="pull-right btn btn-success ">Agregar comision</button></a>
        </header>


        {{ Field::text(
                '',
                '' ,
                [
                    'class' => 'col-md-10' ,
                    'addon-first' => '<i class="fa fa-search"></i>' ,
                    'placeholder' => 'Busca por código postal, colonia, municipio, delegación ó estado',
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
            <p class="col-sm-2"><span class="badge bg-success">@{{commissions.length}}</span> comisiones</p>
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
                        <a href="" ng-click="sort = 'sale.sheet'; reverse=!reverse">Folio de venta
                            <span class="pull-right" >
                                <i class="fa fa-sort" ng-if="sort != 'sale.sheet' "></i>
                                <i class="fa fa-sort-alpha-asc" ng-if=" sort == 'sale.sheet' && reverse == false "></i>
                                <i class="fa  fa-sort-alpha-desc" ng-if=" sort == 'sale.sheet' && reverse == true "></i>
                            </span>
                        </a>
                    </th>
                    <th class="col-sm-1 col-md-1" >
                        <a href="" ng-click="sort = 'total_commission'; reverse=!reverse">Total sobre el que se aplico la comisión
                            <span class="pull-right" >
                                <i class="fa fa-sort" ng-if="sort != 'total_commission' "></i>
                                <i class="fa fa-sort-alpha-asc" ng-if=" sort == 'total_commission' && reverse == false "></i>
                                <i class="fa  fa-sort-alpha-desc" ng-if=" sort == 'total_commission' && reverse == true "></i>
                            </span>
                        </a>
                    </th>
                    <th class="col-sm-1 col-md-1"  class="col-sm-2 col-md-2" >
                        <a href="" ng-click="sort = 'percent'; reverse=!reverse">Porcentaje
                            <span class="pull-right" >
                                <i class="fa fa-sort" ng-if="sort != 'percent' "></i>
                                <i class="fa fa-sort-alpha-asc" ng-if=" sort == 'percent' && reverse == false "></i>
                                <i class="fa  fa-sort-alpha-desc" ng-if=" sort == 'percent' && reverse == true "></i>
                            </span>
                        </a>
                    </th>
                    <th class="col-sm-1 col-md-1" >
                        <a href="" ng-click="sort = 'total'; reverse=!reverse">Comisión
                            <span class="pull-right" >
                                <i class="fa fa-sort" ng-if="sort != 'total' "></i>
                                <i class="fa fa-sort-alpha-asc" ng-if=" sort == 'total' && reverse == false "></i>
                                <i class="fa  fa-sort-alpha-desc" ng-if=" sort == 'total' && reverse == true "></i>
                            </span>
                        </a>
                    </th>
                    <th class="col-sm-2 col-md-2" >
                        <a href="" ng-click="sort = 'employee.user.name'; reverse=!reverse">Empleado que recibio la comisión
                            <span class="pull-right" >
                                <i class="fa fa-sort" ng-if="sort != 'employee.user.name' "></i>
                                <i class="fa fa-sort-alpha-asc" ng-if=" sort == 'employee.user.name' && reverse == false "></i>
                                <i class="fa  fa-sort-alpha-desc" ng-if=" sort == 'employee.user.name'  && reverse == true "></i>
                            </span>
                        </a>
                    </th>
                    <th class="col-sm-1 col-md-1" >
                        <a href="" ng-click="sort = 'type'; reverse=!reverse">Tipo
                            <span class="pull-right" >
                                <i class="fa fa-sort" ng-if="sort != 'type' "></i>
                                <i class="fa fa-sort-alpha-asc" ng-if=" sort == 'type' && reverse == false "></i>
                                <i class="fa  fa-sort-alpha-desc" ng-if=" sort == 'type' && reverse == true "></i>
                            </span>
                        </a>
                    </th>
                    <th class="col-sm-1 col-md-1" >
                        <a href="" ng-click="sort = 'date'; reverse=!reverse">Fecha
                            <span class="pull-right" >
                                <i class="fa fa-sort" ng-if="sort != 'date' "></i>
                                <i class="fa fa-sort-alpha-asc" ng-if=" sort == 'date' && reverse == false "></i>
                                <i class="fa  fa-sort-alpha-desc" ng-if=" sort == 'date' && reverse == true "></i>
                            </span>
                        </a>
                    </th>
                    <th class="col-sm-1 col-md-1" >
                        <a href="" ng-click="sort = 'status_pay'; reverse=!reverse">Estatus de pago
                            <span class="pull-right" >
                                <i class="fa fa-sort" ng-if="sort != 'status_pay' "></i>
                                <i class="fa fa-sort-alpha-asc" ng-if=" sort == 'status_pay' && reverse == false "></i>
                                <i class="fa  fa-sort-alpha-desc" ng-if=" sort == 'status_pay' && reverse == true "></i>
                            </span>
                        </a>
                    </th>
                    <th class="col-sm-2 col-md-2" ></th>
                </tr>
            </thead>
            <tbody  ng-if="viewGrid == 'list'">
                <tr class="gradeX" ng-repeat="commission in commissionsP | orderBy:sort:reverse">
                  <td>@{{ commission.id }}</td>
                  <td>@{{ commission.sale.sheet }}</td>
                  <td>@{{ commission.total_commission | currency }}</td>
                  <td>@{{ commission.percent }} %</td>
                  <td>@{{ commission.total | currency }}</td>
                  <td>@{{ commission.employee.user.name }}</td>
                  <td>@{{ commission.type | commission_types }}</td>
                  <td>@{{ commission.date }}</td>
                  <td>@{{ commission.status_pay }}</td>
                  <td>
                      <a href="@{{ commission.url_edit }}" >
                        <button  type="button" class="col-sm-5 col-sm-offset-1 btn btn-info "><i class="fa fa-refresh"></i></button>
                      </a>
                      <a data-toggle="modal" href="#myModal@{{ commission.id }}" >
                        <button type="button" class="col-sm-5 col-sm-offset-1 btn btn-danger"><i class="fa fa-trash-o"></i></button>
                      </a>
                      <div ng-if="$root.auth_permissions.delete.commission" class="modal fade" id="myModal@{{commission.id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                  <div class="modal-dialog">
                                      <div class="modal-content">
                                          <div class="modal-header">
                                              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                              <h4 class="modal-title">Confirma</h4>
                                          </div>
                                          <div class="modal-body">

                                              ¿Deseas eliminar la comisión con id <strong>@{{commission.id}}</strong>?

                                          </div>
                                          <div class="modal-footer">
                                              <button data-dismiss="modal" class="btn btn-default" type="button">Regresar</button>
                                                <form class="btn " method="POST" action = "@{{ commission.url_delete }}">
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

        <div class="panel" ng-if="commissionsP.length == 0">
            <div class="panel-body">
                <h3 class="text-center">No se encontraron comisiones.</h3>
            </div>
        </div>

        <div class="directory-info-row" ng-if="viewGrid == 'details'">
              <div class="row">
              <div class="col-md-6 col-sm-6 clearfix"  ng-repeat="commission in commissionsP | orderBy:sort:reverse">
                  <div class="panel">
                      <div class="panel-body">
                          <div class="media">
                              <a class="pull-left" href="@{{ commission.url_show }}">
                                  <img class="thumb media-object" src="@{{ commission.image_profile_url }}" alt="">
                              </a>
                              <div class="media-body">
                                  <h4> Folio de venta: @{{ commission.sale.sheet }} </h4>
                                  <div>
                                        <span ng-if="commission.total_commission != ''">Total sobre el que se aplico la comisión: &nbsp;@{{ commission.total_commission | currency }}<br></span>
                                        <span ng-if="commission.percent != ''">Porcentaje: &nbsp;@{{ commission.percent }}%<br></span>
                                        <span ng-if="commission.total != ''">Comisión: &nbsp;@{{ commission.total | currency }}<br></span>
                                        <span ng-if="commission.employee.user.name != ''">Empleado que recibio la comisión: &nbsp;@{{ commission.employee.user.name }}<br></span>
                                        <span ng-if="commission.type != ''">Tipo: &nbsp;@{{ commission.type | commission_types }}<br></span>
                                        <span ng-if="commission.status_pay != ''">Status: &nbsp;@{{ commission.status_pay }}<br></span>
                                  </div>
                                  <div class="col-sm-6 pull-right">
                        <a href="@{{ commission.url_edit }}" class="col-sm-6" ng-if="$root.auth_permissions.update.commission">
                            <button  type="button" class="col-sm-offset-1 btn btn-info "><i class="fa fa-refresh"></i></button>
                        </a>
                        <a data-toggle="modal" href="#myModalD@{{commission.id}}" class="col-sm-6" ng-if="$root.auth_permissions.delete.commission">
                            <button type="button" class="col-sm-offset-1 btn btn-danger"><i class="fa fa-trash-o"></i></button>
                        </a>
                              <div ng-if="$root.auth_permissions.delete.commission" class="modal fade" id="myModalD@{{commission.id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                  <div class="modal-dialog">
                                      <div class="modal-content">
                                          <div class="modal-header">
                                              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                              <h4 class="modal-title">Confirma</h4>
                                          </div>
                                          <div class="modal-body">

                                              ¿Deseas eliminar la comisión con id<strong>@{{commision.id}}</strong>?

                                          </div>
                                          <div class="modal-footer">
                                              <button data-dismiss="modal" class="btn btn-default" type="button">Regresar</button>
                                                <form class="btn " method="POST" action = "@{{ commission.url_delete }}">
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
            'library/js/jquery-ui-1.9.2.custom.min.js' ,
            'library/js/bootstrap-switch.js' ,
            'library/js/jquery.tagsinput.js' ,
            'library/js/ga.js' ,
            'library/js/ng/date.format.js',
            'library/js/ng/commissions.js',
            'library/js/ng/commissions.controllers.js',
            'library/js/ng/commissions.services.js',
            'library/js/ng/commissions.filters.js',
            'library/js/ng/sales.services.js',
            'library/js/ng/users.services.js',
            'library/js/ng/clients.services.js',
            'library/js/ng/products.services.js',
            'library/js/ng/packages.services.js',
            'library/js/ng/destinations.services.js',
            'library/js/ng/ng-date.js',
            'library/js/ng/users.filters.js',
            'library/js/ng/commissions.filters.js',
            'library/js/ng/destinations.filters.js',
            'library/js/ng/directives.js',
        ]
    ]
)

@stop