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

<!-- page start-->
<div ng-app="sales">
	<div class="row"  ng-controller="ShowController" ng-init="$root.generateAuthPermissions({{ Auth::user()->role_id }})">
		<aside class="profile-nav col-lg-3">
			<section class="panel">
				<div class="user-heading round">
					<p>Folio de venta</p>
					<h1>{{ $sale->sheet }}</h1>
				</div>

				<ul class="nav nav-pills nav-stacked" ng-init = "tab = 'venta' ">
					<li><a ng-click="tab = 'venta'" href=""> <i class="fa fa-edit"></i> Detalle</a></li>
					<li><a href="{{ route('sales.edit' , [ $sale->id ]) }}"> <i class="fa fa-edit"></i> Editar venta</a></li>
					@if($sale->sale_type == 'apartado' )
					<li ng-show="$root.auth_permissions.read.sale_payment" ><a ng-click="tab = 'abonos'" href="" > <i class="fa fa-edit"></i> Abonos</a></li>
					@endif
					<li ng-show="$root.auth_permissions.read.commission" ><a ng-click="tab = 'comisiones'" href="" > <i class="fa fa-edit"></i> Comisiones</a></li>
					<li ng-show="$root.auth_permissions.read.delivery"><a ng-click="tab = 'entregas'" href="" > <i class="fa fa-edit"></i> Entregas</a></li>
					<!--<li><a ng-click="tab = 'abonos'"  href="{{ route('sale_payments.create.sale_id' , [ $sale->id ] ) }}"  > <i class="fa fa-edit"></i> Agregar abono</a></li>-->
				</ul>

			</section>
		</aside>
		<aside class="profile-info col-lg-9" ng-if="tab == 'venta' ">

	                      <section class="panel" >
	                      	<div class="panel-heading">
	                      		<h2>Datos de venta. </h2>
	                      	</div>
	                      	<div class="panel-body bio-graph-info">
	                      		<div class="row">
	                      			@if(!empty($sale->employee->user))
	                      			<div class="col-sm-6">
	                      				<span class="col-sm-6">Vendedor </span><p class="col-sm-6"> {{ HTML::link( route('users.show', $sale->employee->id), (isset($sale->employee->user->name) ? $sale->employee->user->name : $sale->employee_id) ) }}</p>
	                      			</div>
	                      			@endif
	                      			@if(!empty($sale->client))
	                      			<div class="col-sm-6">
	                      				<span class="col-sm-6">Cliente </span><p class="col-sm-6">{{ HTML::link( route('clients.show', $sale->client->id), $sale->client->name ) }}</p>
	                      			</div>
	                      			@endif
	                      			<div class="col-sm-6">
	                      				<span class="col-sm-6">Fecha de venta</span><p class="col-sm-6"> {{ $sale->sale_date }}</p>
	                      			</div>
	                      			@if(!empty($sale->pay_type))
	                      			<div class="col-sm-6">
	                      				<span class="col-sm-6">Forma de pago</span><p class="col-sm-6"> {{ $sale->pay_type->name }}</p>
	                      			</div>
	                      			@endif
	                      			<div class="col-sm-6">
	                      				<span class="col-sm-6">Tipo de venta</span><p class="col-sm-6"> {{ $sale->sale_type }}</p>
	                      			</div>
	                      			@if( $sale->sale_type == 'apartado')

	                      			<div class="col-sm-6">
	                      				<span class="col-sm-6">Fecha de liquidación</span><p class="col-sm-6"> {{ $sale->liquidation_date }}</p>
	                      			</div>
	                      			@endif
	                      			<div class="col-sm-6">
	                      				<span class="col-sm-6">Número de productos</span><p class="col-sm-6"> {{ count($sale->products) }}</p>
	                      			</div>
	                      			<div class="col-sm-6">
	                      				<span class="col-sm-6">Número de paquetes</span><p class="col-sm-6"> {{ count($sale->packs) }}</p>
	                      			</div>
	                      			<div class="col-sm-6">
	                      				<span class="col-sm-6">Total</span><p class="col-sm-6"> {{ "<?php echo $sale->total ?>" | currency }}</p>
	                      			</div>
	                      			@if($sale->sale_type == 'apartado' )
	                      			<div class="col-sm-6">
	                      				<span class="col-sm-6">Cantidad Pagada:</span><p class="col-sm-6"> {{ "<?php echo $sale->cleared_payment ?>" | currency }}</p>
	                      			</div>
	                      			<div class="col-sm-6">
	                      				<span class="col-sm-6">Cantidad por pagar:</span><p class="col-sm-6"> {{ "<?php echo $sale->remaining_payment ?>" | currency }}</p>
	                      			</div>
	                      			@endif
	                      		</div>
	                      	</div>
	                      </section>
	                      @if(!empty($sale->packs))
		                      <section class="panel" >
		                      	<div class="panel-heading">
		                      		<h3>Paquetes. </h3>
		                      	</div>
		                      </section>
		                      <section>
		                          <div class="row directory-info-row">
		                          	@foreach($sale->packs as $pack )
		                              <div class="col-md-6 ">
		                                  <div class="panel">
		                                      <div class="panel-body">
		                                          <div class="bio-chart ">
		                                              <img src="{{ $pack->image_url}}" class="img-responsive thumb media-object" />
		                                          </div>
		                                          <div class="bio-desk">
		                                              <h4 class="red">{{ $pack->name }}</h4>
		                                              <p>{{ $pack->key }}</p>
		                                              <p>Cantidad: {{ $pack->pivot->quantity }}</p>
		                                          </div>
		                                      </div>
		                                  </div>
		                              </div>
		                            @endforeach
		                          </div>
		                      </section>
		                  @endif

		                  @if(!empty($sale->products))
		                      <section class="panel" >
		                      	<div class="panel-heading">
		                      		<h3>Productos. </h3>
		                      	</div>
		                      </section>
		                      <section>
		                          <div class="row directory-info-row">
		                          	@foreach($sale->products as $product )
		                              <div class="col-md-6 ">
		                                  <div class="panel">
		                                      <div class="panel-body">
		                                          <div class="bio-chart ">
		                                              <img src="{{ $product->image_url}}" class="img-responsive thumb media-object" />
		                                          </div>
		                                          <div class="bio-desk">
		                                              <h4 class="red">{{ $product->name }}</h4>
		                                              <p>{{ $product->key }}</p>
		                                              <p>{{ $product->model }}</p>
		                                              <p>Cantidad: {{ $product->pivot->quantity }}</p>
		                                          </div>
		                                      </div>
		                                  </div>
		                              </div>
		                            @endforeach
		                          </div>
		                      </section>
	                      @endif

	                  	</aside>


						<aside class="profile-info col-lg-9" ng-if="tab == 'abonos' ">


		                      <section class="panel" >
		                      	<div class="panel-heading">
		                      		<h3>Abonos. </h3>
		                      		<a href="{{ route('sale_payments.create.sale_id' , [ $sale->id ] ) }}" ><button type="button" class="pull-right btn btn-success "> Agregar abono</button></a><br>
		                      	</div>
		                      	<div class="panel-body">
		                      		<table class="table table-bordered table-striped table-condensed">

		                      		@if(!empty($sale->sale_payments))
		                      			<tr>
		                      				<th>Cantidad</th>
		                      				<th>Empleado que recibio</th>
		                      				<th>Fecha</th>
		                      				<th></th>
		                      			</tr>
		                      			@foreach($sale->sale_payments as $sale_payment )
		                      			<tr>
		                      				<td>{{ '<?php echo $sale_payment->total; ?>' | currency }}</td>
		                      				<td>{{ $sale_payment->employee->user->name }}</td>
		                      				<td>{{ $sale_payment->date }}</td>
		                      				<td>
												<a href="{{ $sale_payment->url_edit }}" >
													<button  type="button" class="col-sm-3 col-sm-offset-1 btn btn-info "><i class="fa fa-refresh"></i></button>
												</a>
												<a data-toggle="modal" href="#myModal{{ $sale_payment->id }}" >
													<button type="button" class="col-sm-3 col-sm-offset-1 btn btn-danger"><i class="fa fa-trash-o"></i></button>
												</a>
		                      				</td>
		                      			</tr>

		                      			@endforeach

	                      			@endif
		                      			<tr>
		                      				<td colspan="3" class="text-right">Cantidad pagada</td>
		                      				<td>{{ "<?php echo $sale->cleared_payment ?>" | currency }}</td>
		                      			</tr>
		                      			<tr>
		                      				<td colspan="3" class="text-right">Cantidad por pagar</td>
		                      				<td>{{ "<?php echo $sale->remaining_payment ?>" | currency }}</td>
		                      			</tr>

		                      		</table>

		                      		@if(!empty($sale->sale_payments))

		                      			@foreach($sale->sale_payments as $sale_payment )

		                      				<div class="modal fade" id="myModal{{ $sale_payment->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
												<div class="modal-dialog">
													<div class="modal-content">
														<div class="modal-header">
															<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
															<h4 class="modal-title">Confirma</h4>
														</div>
														<div class="modal-body">

															¿Deseas eliminar el abono  de <strong>{{ '<?php echo $sale_payment->quantity; ?>' | currency }}</strong>?

														</div>
														<div class="modal-footer">
															<form class="btn " method="POST" action="{{ $sale_payment->url_delete }}" >
																<input name="_method" type="hidden" value="DELETE" />
																{{  Form::token() }}
																<button data-dismiss="modal" class="btn btn-default" type="button">Regresar</button>
																<button type="submit" class="btn btn-danger"><i class="fa fa-trash-o"></i>Confirmar</button>
															</form>
														</div>
													</div>
												</div>
											</div>

										@endforeach

	                      			@endif
		                      	</div>

		                      </section>
	                  </aside>

	                  <aside class="profile-info col-lg-9" ng-show="tab == 'comisiones' " ng-if="$root.auth_permissions.read.commission">


		                      <section class="panel" >
		                      	<div class="panel-heading">
		                      		<h3>Comisiones. </h3>
		                      		<a ng-if="$root.auth_permissions.create.commission" href="{{ route('commissions.create.sale_id' , [ $sale->id ] ) }}" ><button type="button" class="pull-right btn btn-success "> Agregar comisión</button></a><br>
		                      	</div>
		                      	<div class="panel-body">
		                      		<table class="table table-bordered table-striped table-condensed">

		                      		@if(!empty($sale->commissions))
		                      			<tr>
		                      				<th class="col-sm-2 col-md-1" >Total sobre el que se aplico la comisión</th>
		                      				<th class="col-sm-1 col-md-1"  class="col-sm-2 col-md-2" >Porcentaje</th>
		                      				<th class="col-sm-1 col-md-1" >Comisión</th>
		                      				<th class="col-sm-2 col-md-2" >Empleado que recibio la comisión</th>
		                      				<th class="col-sm-2 col-md-2" >Tipo</th>
		                      				<th class="col-sm-2 col-md-2" >Fecha</th>
		                      				<th class="col-sm-2 col-md-1" >Estatus de pago</th>
		                      				<th class="col-sm-2 col-md-2" ></th>
		                      			</tr>
		                      			@foreach($sale->commissions as $commission )
		                      			<tr>
		                      				<td>{{ '<?php echo $commission->total_commission; ?>' | currency }}</td>
		                      				<td>{{ $commission->percent }} %</td>
		                      				<td>{{ '<?php echo $commission->total; ?>' | currency }}</td>
		                      				<td>{{ $commission->employee->user->name }}</td>
		                      				<td>{{ '<?php echo $commission->type ?>' | commission_types }}</td>
		                      				<td>{{ $commission->date }}</td>
		                      				<td>{{ $commission->status_pay }}</td>
		                      				<td>
												<a href="{{ $commission->url_edit }}" >
													<button  type="button" class="col-sm-5 col-sm-offset-1 btn btn-info "><i class="fa fa-refresh"></i></button>
												</a>
												<a data-toggle="modal" href="#myModal{{ $commission->id }}" >
													<button type="button" class="col-sm-5 col-sm-offset-1 btn btn-danger"><i class="fa fa-trash-o"></i></button>
												</a>
		                      				</td>
		                      			</tr>



		                      			@endforeach

	                      			@endif

		                      		</table>

		                      		@if(!empty($sale->commissions))

		                      			@foreach($sale->commissions as $commission )

		                      				<div class="modal fade" id="myModal{{ $commission->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
												<div class="modal-dialog">
													<div class="modal-content">
														<div class="modal-header">
															<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
															<h4 class="modal-title">Confirma</h4>
														</div>
														<div class="modal-body">

															¿Deseas eliminar esta comisión?

														</div>
														<div class="modal-footer">
															<form class="btn " method="POST"  action="{{ $commission->url_delete }}">
																<input name="_method" type="hidden" value="DELETE" />
																{{  Form::token() }}
																<button data-dismiss="modal" class="btn btn-default" type="button">Regresar</button>
																<button type="submit" class="btn btn-danger"><i class="fa fa-trash-o"></i>Confirmar</button>
															</form>
														</div>
													</div>
												</div>
											</div>

		                      			@endforeach

	                      			@endif

		                      	</div>

		                      </section>
	                  </aside>

	                  <aside class="profile-info col-lg-9" ng-if="tab == 'entregas' ">

	                  		@include('sales/show/delivery')

	                  </aside>
	              </div>
	            </div>
              <!-- page end-->

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
            'library/js/ng/segments.services.js',
            'library/assets/dropzone/dropzone.js',
            'library/js/jquery.validate.min.js'


            /*new product */
    ]
    ]
    )

              @stop