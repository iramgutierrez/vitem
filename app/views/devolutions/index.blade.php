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




<div ng-app="devolutions" >

	<div class="adv-table" ng-controller="DevolutionsController" ng-init="$root.generateAuthPermissions({{ Auth::user()->role_id }})">
		<div class="panel">
			<div class="panel-body">
				<div ng-view></div>
				<header class="panel-heading col-sm-12">
				<h1 class="col-sm-3">Devoluciones</h1>
					<a ng-if="$root.auth_permissions.create.devolution" href="{{ route('devolutions.create') }}"><button type="button" class="pull-right btn btn-success ">Agregar devolución</button></a>
				</header>

				{{ Field::text(
				'',
				'' ,
				[
				'class' => 'col-md-10' ,
				'addon-first' => '<i class="fa fa-search"></i>' ,
				'placeholder' => 'Busca por id o proveedor.',
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
							<a href="" ng-click="sort = 'devolution_date'; reverse=!reverse">Fecha de devolución
								<span class="pull-right" >
									<i class="fa fa-sort" ng-if="sort != 'devolution_date' "></i>
									<i class="fa fa-sort-alpha-asc" ng-if=" sort == 'devolution_date' && reverse == false "></i>
									<i class="fa  fa-sort-alpha-desc" ng-if=" sort == 'devolution_date' && reverse == true "></i>
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
                                                        $filtersDevolutionDate,
                                                        '' ,
                                                        [
                                                            'ng-model' => 'operatorDevolutionDate',
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
                                                            'ng-model' => 'devolutionDate ',
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
	<tr class="gradeX" ng-repeat="devolution in devolutionsP | orderBy:sort:reverse">
		<td>@{{ devolution.id }}</td>
		<td ng-if="$root.auth_permissions.read.supplier" >@{{ devolution.supplier.name }}</td>
		<td>@{{ devolution.devolution_date }}</td>
		<td>
			<a ng-if="$root.auth_permissions.read.devolution"  href="@{{ devolution.url_show }}" >
				<button type="button" class="col-sm-3 btn btn-success"><i class="fa fa-eye"></i></button>
			</a>
			<a ng-if="$root.auth_permissions.update.devolution" href="@{{ devolution.url_edit }}" >
				<button  type="button" class="col-sm-3 col-sm-offset-1 btn btn-info "><i class="fa fa-refresh"></i></button>
			</a>
			<a ng-if="$root.auth_permissions.delete.devolution" data-toggle="modal" href="#myModal@{{devolution.id}}" >
				<button type="button" class="col-sm-3 col-sm-offset-1 btn btn-danger"><i class="fa fa-trash-o"></i></button>
			</a>
			<div ng-if="$root.auth_permissions.delete.devolution" class="modal fade" id="myModal@{{devolution.id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h4 class="modal-title">Confirma</h4>
						</div>
						<div class="modal-body">

							¿Deseas eliminar el devolución con id <strong>@{{devolution.id}}</strong>?

						</div>
						<div class="modal-footer">
							<form class="btn " method="POST" action = "@{{ devolution.url_delete }}">
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

<div class="panel" ng-if="devolutionsP.length == 0">
	<div class="panel-body">
		<h3 class="text-center">No se encontraron ventas.</h3>
	</div>
</div>

<div class="directory-info-row" ng-if="viewGrid == 'details'">
	<div class="row">
		<div class="col-md-6 col-sm-6 clearfix"  ng-repeat=" devolution in devolutionsP | orderBy:sort:reverse">
			<div class="panel">
				<div class="panel-body">
					<div class="media">
						<div class="media-body col-sm-12">
							<div class="col-sm-12">
								<ul>
									<li class="col-sm-6">Id : @{{devolution.id }}</li>
									<li ng-if="$root.auth_permissions.read.supplier" class="col-sm-6">Proveedor : @{{devolution.supplier.name }}</li>
									<li class="col-sm-6">Fecha de llegada : @{{devolution.devolution_date }}</li>
									<li class="col-sm-6">Número de productos : @{{devolution.products.length }}</li>
									<li class="col-sm-6">Total : @{{devolution.total | currency}}</li>
								</ul>
							</div>
							<div class="col-sm-6 pull-right">

								<a href="@{{ devolution.url_show }}" class="col-sm-4" ng-if="$root.auth_permissions.read.devolution" >
									<button type="button" class=" btn btn-success"><i class="fa fa-eye"></i></button>
								</a>
								<a href="@{{ devolution.url_edit }}" class="col-sm-4" ng-if="$root.auth_permissions.update.devolution" >
									<button  type="button" class="col-sm-offset-1 btn btn-info "><i class="fa fa-refresh"></i></button>
								</a>
								<a data-toggle="modal" href="#myModalD@{{devolution.id}}" class="col-sm-4" ng-if="$root.auth_permissions.delete.devolution" >
									<button type="button" class="col-sm-offset-1 btn btn-danger"><i class="fa fa-trash-o"></i></button>
								</a>
								<div ng-if="$root.auth_permissions.delete.devolution" class="modal fade" id="myModalD@{{devolution.id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
												<h4 class="modal-title">Confirma</h4>
											</div>
											<div class="modal-body">

												¿Deseas eliminar el devolución con id<strong>@{{devolution.id}}</strong>?

											</div>
											<div class="modal-footer">
												<button data-dismiss="modal" class="btn btn-default" type="button">Regresar</button>
												<form class="btn " method="POST" action = "@{{ devolution.url_delete }}">
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
            'library/js/ng/devolutions.js',
            'library/js/ng/devolutions.controllers.js',
            'library/js/ng/devolutions.services.js',
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
            'library/js/ng/colors.services.js',
            'library/assets/dropzone/dropzone.js',
            'library/js/jquery.validate.min.js'


            /*new product */
    ]
    ]
    )


@stop