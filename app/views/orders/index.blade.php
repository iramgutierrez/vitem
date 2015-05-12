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




<div ng-app="orders" >

	<div class="adv-table" ng-controller="OrdersController" ng-init="$root.generateAuthPermissions({{ Auth::user()->role_id }})">
		<div class="panel">
			<div class="panel-body">
				<div ng-view></div>
				<header class="panel-heading col-sm-12">
				<h1 class="col-sm-3">Pedidos</h1>
					<a ng-if="$root.auth_permissions.create.order" href="{{ route('orders.create') }}"><button type="button" class="pull-right btn btn-success ">Agregar pedido</button></a>
				</header>    

				{{ Field::text(
				'', 
				'' , 
				[ 
				'class' => 'col-md-10' , 
				'addon-first' => '<i class="fa fa-search"></i>' , 
				'placeholder' => 'Busca por id o pedido.',
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
						<th class="col-sm-2">                        
							<a href="" ng-click="sort = 'id'; reverse=!reverse">Id
								<span class="pull-right" >
									<i class="fa fa-sort" ng-if="sort != 'id' "></i>
									<i class="fa fa-sort-numeric-asc" ng-if=" sort == 'id' && reverse == false "></i>
									<i class="fa  fa-sort-numeric-desc" ng-if=" sort == 'id' && reverse == true "></i>
								</span>
							</a>
						</th>
						<th ng-show="$root.auth_permissions.read.supplier" class="col-sm-2">
							<a href="" ng-click="sort = 'employee.user.name'; reverse=!reverse">Proveedor
								<span class="pull-right" >
									<i class="fa fa-sort" ng-if="sort != 'employee.user.name' "></i>
									<i class="fa fa-sort-alpha-asc" ng-if=" sort == 'employee.user.name' && reverse == false "></i>
									<i class="fa  fa-sort-alpha-desc" ng-if=" sort == 'employee.user.name' && reverse == true "></i>
								</span>
							</a>
						</th>
						<th class="col-sm-2">
							<a href="" ng-click="sort = 'key'; reverse=!reverse">Fecha de entrega
								<span class="pull-right" >
									<i class="fa fa-sort" ng-if="sort != 'key' "></i>
									<i class="fa fa-sort-alpha-asc" ng-if=" sort == 'key' && reverse == false "></i>
									<i class="fa  fa-sort-alpha-desc" ng-if=" sort == 'key' && reverse == true "></i>
								</span>
							</a>
						</th>
						<th class="col-sm-2"></th>
                </tr>
                <tr>
                	<th></th>
                	<th ng-if="$root.auth_permissions.read.supplier" ></th>
                	<th>
                		

                        <span class="col-sm-12">
                            {{ Field::select(
                                                        '', 
                                                        $filtersOrderDate,
                                                        '' ,
                                                        [ 
                                                            'ng-model' => 'operatorOrderDate',
                                                            'ng-change' => 'search()'
                                                        ]
                                                ) 
                                        }}
                        </span>
                        <span class="col-sm-12">                                                      
                            {{ Field::date(
                                                        '', 
                                                        '' ,
                                                        [ 
                                                            'ng-model' => 'orderDate ',
                                                            'ng-change' => 'search()',
                                                        ]
                                                ) 
                                        }}
                        </span>

                	</th>
<th></th>
</tr>
</thead>
<tbody ng-if="viewGrid == 'list'" >
	<tr class="gradeX" ng-repeat="order in ordersP | orderBy:sort:reverse">
		<td>@{{ order.id }}</td>
		<td ng-if="$root.auth_permissions.read.supplier" >@{{ order.supplier.name }}</td>
		<td>@{{ order.order_date }}</td>
		<td>
			<a ng-if="$root.auth_permissions.read.order"  href="@{{ order.url_show }}" >
				<button type="button" class="col-sm-3 btn btn-success"><i class="fa fa-eye"></i></button>
			</a>
			<a ng-if="$root.auth_permissions.update.order" href="@{{ order.url_edit }}" >
				<button  type="button" class="col-sm-3 col-sm-offset-1 btn btn-info "><i class="fa fa-refresh"></i></button>
			</a>
			<a ng-if="$root.auth_permissions.delete.order" data-toggle="modal" href="#myModal@{{order.id}}" >
				<button type="button" class="col-sm-3 col-sm-offset-1 btn btn-danger"><i class="fa fa-trash-o"></i></button>    
			</a>
			<div ng-if="$root.auth_permissions.delete.order" class="modal fade" id="myModal@{{order.id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h4 class="modal-title">Confirma</h4>
						</div>
						<div class="modal-body">

							¿Deseas eliminar el pedido con id <strong>@{{order.id}}</strong>?

						</div>
						<div class="modal-footer">                                        
							<form class="btn " method="POST" action = "@{{ order.url_delete }}">
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

<div class="panel" ng-if="ordersP.length == 0">
	<div class="panel-body">
		<h3 class="text-center">No se encontraron ventas.</h3>
	</div>
</div>

<div class="directory-info-row" ng-if="viewGrid == 'details'">
	<div class="row">
		<div class="col-md-6 col-sm-6 clearfix"  ng-repeat=" order in ordersP | orderBy:sort:reverse">
			<div class="panel">
				<div class="panel-body">
					<div class="media">
						<div class="media-body col-sm-12">
							<div class="col-sm-12">
								<ul>
									<li class="col-sm-6">Id : @{{order.id }}</li>
									<li ng-if="$root.auth_permissions.read.supplier" class="col-sm-6">Proveedor : @{{order.supplier.name }}</li>
									<li class="col-sm-6">Fecha de llegada : @{{order.order_date }}</li>
									<li class="col-sm-6">Número de productos : @{{order.products.length }}</li>
									<li class="col-sm-6">Total : @{{order.total | currency}}</li>
								</ul>
							</div>
							<div class="col-sm-6 pull-right">

								<a href="@{{ order.url_show }}" class="col-sm-4" ng-if="$root.auth_permissions.read.order" >
									<button type="button" class=" btn btn-success"><i class="fa fa-eye"></i></button>
								</a>
								<a href="@{{ order.url_edit }}" class="col-sm-4" ng-if="$root.auth_permissions.update.order" >
									<button  type="button" class="col-sm-offset-1 btn btn-info "><i class="fa fa-refresh"></i></button>
								</a>
								<a data-toggle="modal" href="#myModalD@{{order.id}}" class="col-sm-4" ng-if="$root.auth_permissions.delete.order" >
									<button type="button" class="col-sm-offset-1 btn btn-danger"><i class="fa fa-trash-o"></i></button>    
								</a>
								<div ng-if="$root.auth_permissions.delete.order" class="modal fade" id="myModalD@{{order.id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
												<h4 class="modal-title">Confirma</h4>
											</div>
											<div class="modal-body">

												¿Deseas eliminar el pedido con id<strong>@{{order.id}}</strong>?

											</div>
											<div class="modal-footer">
												<button data-dismiss="modal" class="btn btn-default" type="button">Regresar</button>                                              
												<form class="btn " method="POST" action = "@{{ order.url_delete }}">
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
            'library/js/ng/orders.js',
            'library/js/ng/orders.controllers.js',
            'library/js/ng/orders.services.js',
            'library/js/ng/products.services.js',
            'library/js/ng/suppliers.services.js',
            'library/js/ng/users.filters.js',
            'library/js/ng/directives.js',
            'library/js/jquery-ui-1.9.2.custom.min.js' ,
            'library/assets/bootstrap-fileupload/bootstrap-fileupload.js',


            /*new product */
            'library/js/ng/products.filters.js',
            'library/js/ng/products.services.js',
            'library/js/ng/suppliers.services.js',
            'library/assets/dropzone/dropzone.js',
            'library/js/jquery.validate.min.js'


            /*new product */
    ]
    ]
    )


@stop