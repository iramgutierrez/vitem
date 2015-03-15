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




<div ng-app="sales" >

	<div class="adv-table" ng-controller="SalesController" ng-init="$root.generateAuthPermissions({{ Auth::user()->role_id }})">
		<div class="panel">
			<div class="panel-body">
				<div ng-view></div>
				<header class="panel-heading col-sm-12">
				<h1 class="col-sm-3">Ventas</h1>
					<a ng-if="$root.auth_permissions.create.sale" href="{{ route('sales.create') }}"><button type="button" class="pull-right btn btn-success ">Agregar venta</button></a>
				</header>    

				{{ Field::text(
				'', 
				'' , 
				[ 
				'class' => 'col-md-10' , 
				'addon-first' => '<i class="fa fa-search"></i>' , 
				'placeholder' => 'Busca por id, folio, empleado,cliente o sucursal.',
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
						<th class="col-sm-1" ng-show="$root.auth_permissions.read.user">
							<a href="" ng-click="sort = 'employee.user.name'; reverse=!reverse">Empleado
								<span class="pull-right" >
									<i class="fa fa-sort" ng-if="sort != 'employee.user.name' "></i>
									<i class="fa fa-sort-alpha-asc" ng-if=" sort == 'employee.user.name' && reverse == false "></i>
									<i class="fa  fa-sort-alpha-desc" ng-if=" sort == 'employee.user.name' && reverse == true "></i>
								</span>
							</a>
						</th>
						<th class="col-sm-1" ng-show="$root.auth_permissions.read.client" >
							<a href="" ng-click="sort = 'client.name'; reverse=!reverse">Cliente
								<span class="pull-right" >
									<i class="fa fa-sort" ng-if="sort != 'client.name' "></i>
									<i class="fa fa-sort-alpha-asc" ng-if=" sort == 'client.name' && reverse == false "></i>
									<i class="fa  fa-sort-alpha-desc" ng-if=" sort == 'client.name' && reverse == true "></i>
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
							<a href="" ng-click="sort = 'key'; reverse=!reverse">Fecha de venta
								<span class="pull-right" >
									<i class="fa fa-sort" ng-if="sort != 'key' "></i>
									<i class="fa fa-sort-alpha-asc" ng-if=" sort == 'key' && reverse == false "></i>
									<i class="fa  fa-sort-alpha-desc" ng-if=" sort == 'key' && reverse == true "></i>
								</span>
							</a>
						</th>
						<th class="col-sm-1">
							<a href="" ng-click="sort = 'sale_type'; reverse=!reverse">Tipo de venta
								<span class="pull-right" >
									<i class="fa fa-sort" ng-if="sort != 'sale_type' "></i>
									<i class="fa fa-sort-alpha-asc" ng-if=" sort == 'sale_type' && reverse == false "></i>
									<i class="fa  fa-sort-alpha-desc" ng-if=" sort == 'sale_type' && reverse == true "></i>
								</span>
							</a>
						</th>
						<th class="col-sm-1" >
							<a href="" ng-click="sort = 'pay_type.name'; reverse=!reverse">Forma de pago
								<span class="pull-right" >
									<i class="fa fa-sort" ng-if="sort != 'pay_type.name' "></i>
									<i class="fa fa-sort-alpha-asc" ng-if=" sort == 'pay_type.name' && reverse == false "></i>
									<i class="fa  fa-sort-alpha-desc" ng-if=" sort == 'pay_type.name' && reverse == true "></i>
								</span>
							</a>
						</th>
						<th class="col-sm-2"></th>
                </tr>
                <tr>
                	<th></th>
                	<th ng-if="$root.auth_permissions.read.user"></th>
                	<th ng-if="$root.auth_permissions.read.client" ></th>
                	<th ng-if="$root.auth_permissions.read.store" ></th>
                	<th>
                		

                        <span class="col-sm-12">
                            {{ Field::select(
                                                        '', 
                                                        $filtersSaleDate,
                                                        '' ,
                                                        [ 
                                                            'ng-model' => 'operatorSaleDate',
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
                                                            'ng-model' => 'saleDate ',
                                                            'ng-change' => 'search()'
                                                        ]
                                                ) 
                                        }}
                        </span>

                	</th>
     
<th>
	<span class="">
		{{ Field::select(
		'', 
		$sale_types,
		'' ,
		[ 
		'ng-model' => 'sale_type',
		'ng-change' => 'search()'
		]
		) 
	}}
</span>
</th>
<th>
	
	<span class="">
		{{ Field::select(
		'', 
		$pay_types,
		'' ,
		[ 
		'ng-model' => 'pay_type',
		'ng-change' => 'search()'
		]
		) 
	}}
</span>
</th>
<th></th>
</tr>
</thead>
<tbody ng-if="viewGrid == 'list'" >
	<tr class="gradeX" ng-repeat="sale in salesP | orderBy:sort:reverse">
		<td>@{{ sale.id }}</td>
		<td ng-if="$root.auth_permissions.read.user" >@{{ sale.employee.user.name }}</td>
		<td ng-if="$root.auth_permissions.read.client" >@{{ sale.client.name }}</td>
		<td ng-if="$root.auth_permissions.read.store" >@{{ sale.store.name }}</td>
		<td>@{{ sale.sale_date }}</td>
		<td>@{{ sale.sale_type }}</td>
		<td>@{{ sale.pay_type.name }}</td>
		<td>
			<a href="@{{ sale.url_show }}" ng-if="$root.auth_permissions.read.sale"  >
				<button type="button" class="col-sm-3 btn btn-success"><i class="fa fa-eye"></i></button>
			</a>
			<a href="@{{ sale.url_edit }}" ng-if="$root.auth_permissions.update.sale" >
				<button  type="button" class="col-sm-3 col-sm-offset-1 btn btn-info "><i class="fa fa-refresh"></i></button>
			</a>
			<a data-toggle="modal" href="#myModal@{{sale.id}}" ng-if="$root.auth_permissions.delete.sale" >
				<button type="button" class="col-sm-3 col-sm-offset-1 btn btn-danger"><i class="fa fa-trash-o"></i></button>    
			</a>
			<div ng-if="$root.auth_permissions.delete.sale" class="modal fade" id="myModal@{{sale.id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h4 class="modal-title">Confirma</h4>
						</div>
						<div class="modal-body">

							¿Deseas eliminar la venta con folio <strong>@{{sale.sheet}}</strong>?

						</div>
						<div class="modal-footer">                                        
							<form class="btn " method="POST" action = "@{{ sale.url_delete }}">
								<input name="_method" type="hidden" value="DELETE">
								{{  Form::token() }}
								{{

									Field::checkbox(
									 'add_stock',
									 '1',
									  [
									  ] ,
									  [
									  'label-value' => 'Agregar los productos de esta venta al stock',
									  ]                                     
									);
								}}
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

<div class="panel" ng-if="salesP.length == 0">
	<div class="panel-body">
		<h3 class="text-center">No se encontraron ventas.</h3>
	</div>
</div>

<div class="directory-info-row" ng-if="viewGrid == 'details'">
	<div class="row">
		<div class="col-md-6 col-sm-6 clearfix"  ng-repeat=" sale in salesP | orderBy:sort:reverse">
			<div class="panel">
				<div class="panel-body">
					<div class="media">
						<div class="media-body col-sm-12">
							<div class="col-sm-12">
								<ul>
									<li class="col-sm-6">Folio : @{{sale.sheet }}</li>
									<li class="col-sm-6" ng-if="$root.auth_permissions.read.user" >Vendedor : @{{sale.employee.user.name }}</li>
									<li class="col-sm-6" ng-if="$root.auth_permissions.read.client" >Cliente : @{{sale.client.name }}</li>
									<li class="col-sm-6" ng-if="$root.auth_permissions.read.store" >Cliente : @{{sale.store.name }}</li>
									<li class="col-sm-6">Fecha de venta : @{{sale.sale_date }}</li>
									<li class="col-sm-6">Tipo de venta : @{{sale.sale_type }}</li>
									<li class="col-sm-6">Forma de pago : @{{sale.pay_type }}</li>
									<li class="col-sm-6">Número de productos : @{{sale.products.length }}</li>
									<li class="col-sm-6">Número de paquetes : @{{sale.packs.length }}</li>
									<li class="col-sm-6">Total : @{{sale.total | currency}}</li>
								</ul>
							</div>
							<div class="col-sm-6 pull-right">

								<a href="@{{ sale.url_show }}" class="col-sm-4" ng-if="$root.auth_permissions.read.sale" >
									<button type="button" class=" btn btn-success"><i class="fa fa-eye"></i></button>
								</a>
								<a href="@{{ sale.url_edit }}" class="col-sm-4" ng-if="$root.auth_permissions.update.sale" >
									<button  type="button" class="col-sm-offset-1 btn btn-info "><i class="fa fa-refresh"></i></button>
								</a>
								<a data-toggle="modal" href="#myModalD@{{sale.id}}" class="col-sm-4" ng-if="$root.auth_permissions.delete.sale" >
									<button type="button" class="col-sm-offset-1 btn btn-danger"><i class="fa fa-trash-o"></i></button>    
								</a>
								<div ng-if="$root.auth_permissions.delete.sale" class="modal fade" id="myModalD@{{sale.id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
												<h4 class="modal-title">Confirma</h4>
											</div>
											<div class="modal-body">

												¿Deseas eliminar la venta con folio<strong>@{{sale.sheet}}</strong>?

											</div>
											<div class="modal-footer">
												<button data-dismiss="modal" class="btn btn-default" type="button">Regresar</button>                                              
												<form class="btn " method="POST" action = "@{{ sale.url_delete }}">
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
	        'library/js/ng/sales.js',
	        'library/js/ng/sales.controllers.js',
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