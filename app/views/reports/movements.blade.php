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




<div ng-app="reports" >

	<div class="adv-table" ng-controller="MovementsController">
		<div class="panel">
			<div class="panel-body">
				<div ng-view></div>
				<header class="panel-heading col-sm-12">
					<h1 class="col-sm-3">Movimientos</h1>
				</header>

				{{ Form::open(['route' => 'reports.generate_xls']) }}

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
				<div class="form-group col-sm-12">

					<div class="form-group col-sm-12">
						<pagination></pagination>

					</div>
					<p class="form-group col-sm-2">
						<span class="badge bg-success">@{{total}}</span> movimientos
					</p>
					<div class="form-group pull-right">
						<button type="button" ng-click="clear()" class="btn btn-info">Limpiar filtros</button>
						<button type="submit" class="btn btn-success">Generar XLS</button>
					</div>
				</div>

				{{ Form::close() }}

				<div class="clearfix"></div>

				<br><br><br>

				<div class="tableContainerReport" style="width: 100%; overflow:auto;">
					<table  class="display table table-bordered table-striped" id="dynamic-table" >
						<thead>
							<tr >
								<th class="col-sm-1" >ID</th>
								<th class="col-sm-1" >Usuario de sistema</th>
								<th class="col-sm-1" >Sucursal</th>
								<th class="col-sm-1" >Tipo</th>
								<th class="col-sm-1" >Tipo de entidad</th>
								<th class="col-sm-1" >Id de entidad</th>
								<th class="col-sm-1" >Fecha</th>
								<th class="col-sm-1" >Cantidad entrante</th>
								<th class="col-sm-1" >Cantidad saliente</th>
								<th class="col-sm-1" >Total</th>
		                	</tr>
						</thead>
						<tbody>
							<tr class="gradeX" ng-repeat="movement in movementsP | orderBy:sort:reverse">
								<td>@{{ movement.id }}</td>
								<td>@{{ movement.user.name }}</td>
								<td>@{{ movement.store.name }} </td>
								<td>@{{ movement.type }}</td>
								<td>@{{ movement.entity }}</td>
								<td>@{{ movement.entity_id }}</td>
								<td>@{{ movement.date | date:'yyyy-MM-dd'}}</td>
								<td>@{{ movement.amount_in | currency }}</td>
								<td>@{{ movement.amount_out | currency }}</td>
								<td>@{{ movement.amount_in - movement.amount_out | currency }}</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>

		<div class="panel" ng-if="salesP.length == 0">
			<div class="panel-body">
				<h3 class="text-center">No se encontraron movimientos.</h3>
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
        'library/js/ng/reports.js',
        'library/js/ng/reports.controllers.js',
        'library/js/ng/sales.services.js',
        'library/js/ng/movements.services.js',
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
'library/js/ng/users.filters.js',
'library/js/ng/commissions.filters.js',
'library/js/ng/commissions.filters.js'
]
]
)

@stop