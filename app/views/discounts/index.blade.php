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




    <div ng-app="discounts" >

        <div class="adv-table" ng-controller="DiscountsController" ng-init="$root.generateAuthPermissions({{ Auth::user()->role_id }})">
            <div class="panel">
                <div class="panel-body">
                    <div ng-view></div>
                    <header class="panel-heading col-sm-12">
                        <h1 class="col-sm-3">Descuentos</h1>
                        <a ng-if="$root.auth_permissions.create.discount" href="{{ route('discounts.create') }}"><button type="button" class="pull-right btn btn-success ">Agregar descuento</button></a>
                    </header>

                    {{ Field::text(
                        '',
                        '' ,
                        [
                        'class' => 'col-md-10' ,
                        'addon-first' => '<i class="fa fa-search"></i>' ,
                        'placeholder' => 'Busca por id o producto.',
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
                        <p class="col-sm-2"><span class="badge bg-success">@{{total}}</span> ventas</p>
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
									<i class="fa fa-sort-numeric-asc" ng-if=" sort == 'id' && reverse == false "></i>
									<i class="fa  fa-sort-numeric-desc" ng-if=" sort == 'id' && reverse == true "></i>
								</span>
                                </a>
                            </th>
                            <th class="col-sm-1">
                                <a href="" ng-click="sort = 'type'; reverse=!reverse">Tipo
								<span class="pull-right" >
									<i class="fa fa-sort" ng-if="sort != 'type' "></i>
									<i class="fa fa-sort-numeric-asc" ng-if=" sort == 'type' && reverse == false "></i>
									<i class="fa  fa-sort-numeric-desc" ng-if=" sort == 'type' && reverse == true "></i>
								</span>
                                </a>
                            </th>
                            <th class="col-sm-1">
                                <a href="" ng-click="sort = 'init_date'; reverse=!reverse">Fecha de inicio
								<span class="pull-right" >
									<i class="fa fa-sort" ng-if="sort != 'init_date' "></i>
									<i class="fa fa-sort-alpha-asc" ng-if=" sort == 'init_date' && reverse == false "></i>
									<i class="fa  fa-sort-alpha-desc" ng-if=" sort == 'init_date' && reverse == true "></i>
								</span>
                                </a>
                            </th>
                            <th class="col-sm-1">
                                <a href="" ng-click="sort = 'end_date'; reverse=!reverse">Fecha de fin
								<span class="pull-right" >
									<i class="fa fa-sort" ng-if="sort != 'end_date' "></i>
									<i class="fa fa-sort-alpha-asc" ng-if=" sort == 'end_date' && reverse == false "></i>
									<i class="fa  fa-sort-alpha-desc" ng-if=" sort == 'end_date' && reverse == true "></i>
								</span>
                                </a>
                            </th>
                            <th class="col-sm-1">
                                <a href="" ng-click="sort = 'quantity'; reverse=!reverse">Descuento
								<span class="pull-right" >
									<i class="fa fa-sort" ng-if="sort != 'quantity' "></i>
									<i class="fa fa-sort-numeric-asc" ng-if=" sort == 'quantity' && reverse == false "></i>
									<i class="fa  fa-sort-numeric-desc" ng-if=" sort == 'quantity' && reverse == true "></i>
								</span>
                                </a>
                            </th>
                            <th class="col-sm-1">
                                <a href="" ng-click="sort = 'item.name'; reverse=!reverse">Producto
								<span class="pull-right" >
									<i class="fa fa-sort" ng-if="sort != 'item.name' "></i>
									<i class="fa fa-sort-numeric-asc" ng-if=" sort == 'item.name' && reverse == false "></i>
									<i class="fa  fa-sort-numeric-desc" ng-if=" sort == 'item.name' && reverse == true "></i>
								</span>
                                </a>
                            </th>
                            <th class="col-sm-2">
                                Sucursales
                            </th>
                            <th class="col-sm-2">
                                Formas de pago
                            </th>
                            <th class="col-sm-2"></th>
                        </tr>
                        <tr>
                            <th></th>
                            <th>
                                {{ Field::select(
                                        '',
                                        $types,
                                        '' ,
                                        [
                                            'ng-model' => 'type',
                                            'ng-change' => 'search()'
                                        ]
                                    )
                                }}
                            </th>
                            <th>
                                {{ Field::date(
                                        '',
                                        '' ,
                                        [
                                            'ng-model' => 'initDate',
                                            'ng-change' => 'search()',
                                        ]
                                    )
                                }}
                            </th>
                            <th>
                                {{ Field::date(
                                        '',
                                        '' ,
                                        [
                                            'ng-model' => 'endDate',
                                            'ng-change' => 'search()',
                                        ]
                                    )
                                }}
                            </th>
                            <th>
                                {{ Field::select(
                                        '',
                                        $discount_types,
                                        '' ,
                                        [
                                            'ng-model' => 'discountType',
                                            'ng-change' => 'search()'
                                        ]
                                    )
                                }}
                            </th>
                            <th></th>
                            <th>
                                {{ Field::select(
                                        '',
                                        $stores,
                                        '' ,
                                        [
                                            'ng-model' => 'store',
                                            'ng-change' => 'search()'
                                        ]
                                    )
                                }}
                            </th>
                            <th>
                                {{ Field::select(
                                        '',
                                        $pay_types,
                                        '' ,
                                        [
                                            'ng-model' => 'payType',
                                            'ng-change' => 'search()'
                                        ]
                                    )
                                }}
                            </th>
                        </tr>
                        </thead>
                        <tbody ng-if="viewGrid == 'list'" >
                        <tr class="gradeX" ng-repeat="discount in discountsP | orderBy:sort:reverse">
                            <td>@{{ discount.id }}</td>
                            <td>@{{ discount.type | type }}</td>
                            <td>@{{ discount.init_date }}</td>
                            <td>@{{ discount.end_date }}</td>
                            <td>@{{ discount.discount_type | discountType }} - @{{ discount | quantityDiscountType }}</td>
                            <td>@{{ discount.item.name }}</td>
                            <td>
                                <ul>
                                    <li data-ng-repeat="store in discount.stores"> @{{ store.name }}</li>
                                </ul>
                            </td>
                            <td>
                                <ul>
                                    <li data-ng-repeat="pay_type in discount.pay_types"> @{{ pay_type.name }}</li>
                                </ul>
                            </td>
                            <td>
                                <a ng-if="$root.auth_permissions.update.discount" href="@{{ discount.url_edit }}" >
                                    <button  type="button" class="col-sm-4 col-sm-offset-1 btn btn-info "><i class="fa fa-refresh"></i></button>
                                </a>
                                <a ng-if="$root.auth_permissions.delete.discount" data-toggle="modal" href="#myModal@{{discount.id}}" >
                                    <button type="button" class="col-sm-4 col-sm-offset-1 btn btn-danger"><i class="fa fa-trash-o"></i></button>
                                </a>
                                <div ng-if="$root.auth_permissions.delete.discount" class="modal fade" id="myModal@{{discount.id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                <h4 class="modal-title">Confirma</h4>
                                            </div>
                                            <div class="modal-body">

                                                ¿Deseas eliminar el descuento con id <strong>@{{discount.id}}</strong>?

                                            </div>
                                            <div class="modal-footer">
                                                <form class="btn " method="POST" action = "@{{ discount.url_delete }}">
                                                    <input name="_method" type="hidden" value="DELETE">
                                                    {{  Form::token() }}

                                                    <button data-dismiss="modal" class="btn btn-default" type="button">Regresar</button>
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

            <div class="panel" ng-if="discountsP.length == 0">
                <div class="panel-body">
                    <h3 class="text-center">No se encontraron descuentos.</h3>
                </div>
            </div>

            <div class="directory-info-row" ng-if="viewGrid == 'details'">
                <div class="row">
                    <div class="col-md-6 col-sm-6 clearfix"  ng-repeat=" discount in discountsP | orderBy:sort:reverse">
                        <div class="panel">
                            <div class="panel-body">
                                <div class="media">
                                    <div class="media-body col-sm-12">
                                        <div class="col-sm-12">
                                            <ul>
                                                <li class="col-sm-6"><b>Id :</b> @{{discount.id }}</li>
                                                <li class="col-sm-6"><b>Tipo :</b> @{{ discount.type |type }}</li>
                                                <li class="col-sm-6"><b>Fecha de inicio :</b> @{{discount.init_date }}</li>
                                                <li class="col-sm-6"><b>Fecha de fin :</b> @{{discount.end_date }}</li>
                                                <li class="col-sm-6"><b>Tipo de descuento :</b> @{{discount.discount_type | discountType }}</li>
                                                <li class="col-sm-6"><b>Cantidad de descuento :</b> @{{discount | quantityDiscountType }}</li>
                                                <li class="col-sm-6">
                                                    <b>Sucursales</b>
                                                    <ul>
                                                        <li data-ng-repeat="store in discount.stores"> @{{ store.name }}</li>
                                                    </ul>
                                                </li>
                                                <li class="col-sm-6">
                                                    <b>Formas de pago</b>
                                                    <ul>
                                                        <li data-ng-repeat="pay_type in discount.pay_types"> @{{ pay_type.name }}</li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="col-sm-6 pull-right">
                                            <a href="@{{ discount.url_edit }}" class="col-sm-6" ng-if="$root.auth_permissions.update.discount" >
                                                <button  type="button" class="col-sm-offset-1 btn btn-info "><i class="fa fa-refresh"></i></button>
                                            </a>
                                            <a data-toggle="modal" href="#myModalD@{{discount.id}}" class="col-sm-6" ng-if="$root.auth_permissions.delete.discount" >
                                                <button type="button" class="col-sm-offset-1 btn btn-danger"><i class="fa fa-trash-o"></i></button>
                                            </a>
                                            <div ng-if="$root.auth_permissions.delete.discount" class="modal fade" id="myModalD@{{discount.id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                            <h4 class="modal-title">Confirma</h4>
                                                        </div>
                                                        <div class="modal-body">

                                                            ¿Deseas eliminar el descuento con id<strong>@{{discount.id}}</strong>?

                                                        </div>
                                                        <div class="modal-footer">
                                                            <button data-dismiss="modal" class="btn btn-default" type="button">Regresar</button>
                                                            <form class="btn " method="POST" action = "@{{ discount.url_delete }}">
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
            'library/js/ng/date.format.js',
            'library/js/ng/discounts.js',
            'library/js/ng/discounts.controllers.js',
            'library/js/ng/discounts.services.js',
            'library/js/ng/products.services.js',
            'library/js/ng/packages.services.js',
            'library/js/ng/pay_types.services.js',
            'library/js/ng/stores.services.js',
            'library/js/ng/users.filters.js',
            'library/js/ng/directives.js',
            'library/js/jquery-ui-1.9.2.custom.min.js' ,
    ]
    ]
    )

@stop