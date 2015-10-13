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

<div ng-app="commissions" >

    <div class="adv-table" ng-controller="SalesController">
        <div class="panel">
            <div class="panel-body">
                <div ng-view></div>
                <header class="panel-heading col-sm-12">
                <h1 class="col-sm-12">Agregar comisiones</h1>

                </header>


                <hr>
                <div class="clearfix"></div>
                <hr>
                <div class="form-group col-md-12 col-sm-12 " >

                     @include('reports/fields/employee_id')

                </div>

                <div class="form-group col-md-12 col-sm-12 " >

                    @include('reports/fields/client_id')

                </div>
                <div class="form-group col-sm-4">

                    {{
                    Field::date
                        (
                            'init_date',
                            '',
                            [
                                'ng-model' => 'initDate',
                                'ng-change' => 'search()'
                            ]
                        )
                    }}

                </div>
                <div class="form-group col-sm-4">

                    {{
                    Field::date
                        (
                            'end_date',
                            '',
                            [
                                'ng-model' => 'endDate',
                                'ng-change' => 'search()'
                            ]
                        )
                    }}

                </div>

                <div class="form-group col-sm-4">

                    {{ Field::select(
                        'pay_type_id',
                        $pay_types,
                        '' ,
                        [
                        'ng-model' => 'pay_type_id',
                        'ng-change' => 'search()'
                        ]
                        )
                    }}

                </div>

                <div class="form-group col-sm-4">

                    {{ Field::select(
                        'sale_type',
                        $sale_types,
                        '' ,
                        [
                        'ng-model' => 'sale_type',
                        'ng-change' => 'search()'
                        ]
                        )
                    }}

                </div>

                <div class="form-group col-sm-4">

                    {{ Field::select(
                        'percent_cleared_payment_type',
                        [
                            "<=" => 'Menor o igual que',
                            "==" => 'Igual',
                            ">=" => 'Mayor o igual que'
                        ],
                        '' ,
                        [
                        'ng-model' => 'percent_cleared_payment_type',
                        'ng-change' => 'search()'
                        ]
                        )
                    }}

                </div>

                <div class="form-group col-sm-4">
                    {{ Field::text
                        (
                            'percent_cleared_payment',
                            '' ,
                            [

                                'addon-last' => '%' ,

                                'placeholder' => 'Ingresa el porcentaje',

                                'ng-model' => 'percent_cleared_payment',

                                'ng-change' => 'search()',

                            ]

                        )

                    }}

                </div>



                <div class="form-group col-sm-12">

                    <div class="form-group col-sm-12">
                        <pagination></pagination>

                    </div>
                    <p class="form-group col-sm-2">
                        <span class="badge bg-success">@{{total}}</span> ventas
                    </p>
                    <div class="form-group pull-right">
                        {{ Form::open(['route' => 'commissions.create_many']) }}
                            <button type="button" ng-click="clear()" class="btn btn-info">Limpiar filtros</button>

                            <button type="submit" class="btn btn-success">Asignar comisiones</button>
                            <input type="hidden" name="commissions" ng-model="commissionsJson" ng-value="commissionsJson">
                        {{ Form::close() }}
                    </div>
                </div>

                <div class="clearfix"></div>
                <br><br><br>
                <div class="tableContainerReport" style="width: 100%; overflow:auto;">
                    <table  class="display table table-bordered table-striped" id="dynamic-table" >
                        <thead>
                            <tr>
                                <th colspan="12">
                                    <input type="checkbox" name="all" ng-click="selectAllSales()" ng-model="allSales" >
                                    <label for="all">Todos</label>
                                </th>
                            </tr>
                            <tr >
                                <th class="col-sm-1" >ID</th>
                                <th class="col-sm-1" >Folio</th>
                                <th class="col-sm-1" >Empleado</th>
                                <th class="col-sm-1" >Cliente</th>
                                <th class="col-sm-1" >Fecha de venta</th>
                                <th class="col-sm-1" >Tipo de venta</th>
                                <th class="col-sm-1" >Cantidad pagado</th>
                                <th class="col-sm-1" >Porcentaje pagado</th>
                                <th class="col-sm-1" >Forma de pago</th>
                                <th class="col-sm-1" >Total de venta</th>
                                <th class="col-sm-1" >Comisión a forma de pago</th>
                                <th class="col-sm-1" >Total en caja</th>
                                {{--<th>Productos</th>
                                <th>Paquetes</th>
                                <th>Comisiones</th>
                                <th>Entrega</th>--}}
                            </tr>
                        </thead>
                        <tbody ng-if="viewGrid == 'list'" >
                            <tr class="gradeX" ng-repeat="(s ,sale) in salesP | orderBy:sort:reverse">
                                <td>
                                    <input type="checkbox" name="commissions[]" ng-model="sales[s].addCommission" ng-value="sales[s].addCommission" ng-change="updateCommissions(sale.id)" >
                                    <label for="add_@{{ sale.id }}">@{{ sale.id }}</label>
                                </td>
                                <td>@{{ sale.sheet }}</td>
                                <td>@{{ sale.employee.user.name }} </td>
                                <td>@{{ sale.client.name }}</td>
                                <td>@{{ sale.sale_date }}</td>
                                <td>@{{ sale.sale_type }}</td>
                                <td>@{{ sale.cleared_payment | currency}}</td>
                                <td>@{{ sale.percent_cleared_payment }}%</td>
                                <td>@{{ sale.pay_type.name }}</td>
                                <td>@{{ sale.subtotal | currency}}</td>
                                <td>@{{ sale.commission_pay | currency}}</td>
                                <td>@{{ sale.total | currency}}</td>

                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="panel" ng-if="salesP.length == 0">
            <div class="panel-body">
                <h3 class="text-center">No se encontraron ventas.</h3>
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