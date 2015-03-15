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




<div ng-app="stores" >

	<div class="adv-table" ng-controller="StoresController" ng-init="$root.generateAuthPermissions({{ Auth::user()->role_id }})">
		<div class="panel">
			<div class="panel-body">
				<div ng-view></div>
				<header class="panel-heading col-sm-12">
				<h1 class="col-sm-3">Sucursales</h1>
					<a ng-if="$root.auth_permissions.create.store" href="{{ route('stores.create') }}"><button type="button" class="pull-right btn btn-success ">Agregar sucursal</button></a>
				</header>    

				{{ Field::text(
				'', 
				'' , 
				[ 
				'class' => 'col-md-10' , 
				'addon-first' => '<i class="fa fa-search"></i>' , 
				'placeholder' => 'Busca por id, nombre, correo electrónico, dirección o teléfono.',
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
				<p class="col-sm-2"><span class="badge bg-success">@{{total}}</span> sucursales</p>        
				<button type="button" ng-click="clear()" class="pull-right btn btn-info">Limpiar filtros</button>
			</div>
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
						<th class="col-sm-2">
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
						<th class="col-sm-2">
							<a href="" ng-click="sort = 'address'; reverse=!reverse">Dirección
								<span class="pull-right" >
									<i class="fa fa-sort" ng-if="sort != 'address' "></i>
									<i class="fa fa-sort-alpha-asc" ng-if=" sort == 'address' && reverse == false "></i>
									<i class="fa  fa-sort-alpha-desc" ng-if=" sort == 'address' && reverse == true "></i>
								</span>
							</a>
						</th>
						<th class="col-sm-2">
							<a href="" ng-click="sort = 'phone'; reverse=!reverse">Teléfono
								<span class="pull-right" >
									<i class="fa fa-sort" ng-if="sort != 'phone' "></i>
									<i class="fa fa-sort-alpha-asc" ng-if=" sort == 'phone' && reverse == false "></i>
									<i class="fa  fa-sort-alpha-desc" ng-if=" sort == 'phone' && reverse == true "></i>
								</span>
							</a>
						</th>
						<th class="col-sm-2"></th>
                </tr>
</thead>
<tbody>
	<tr class="gradeX" ng-repeat="store in storesP | orderBy:sort:reverse">
		<td>@{{ store.id }}</td>
		<td>@{{ store.name }}</td>
		<td>@{{ store.email }}</td>
		<td>@{{ store.address }}</td>
		<td>@{{ store.phone }}</td>
		<td>
			<a ng-if="$root.auth_permissions.read.store"  href="@{{ store.url_show }}" >
				<button type="button" class="col-sm-3 btn btn-success"><i class="fa fa-eye"></i></button>
			</a>
			<a ng-if="$root.auth_permissions.update.store" href="@{{ store.url_edit }}" >
				<button  type="button" class="col-sm-3 col-sm-offset-1 btn btn-info "><i class="fa fa-refresh"></i></button>
			</a>
			<a ng-if="$root.auth_permissions.delete.store" data-toggle="modal" href="#myModal@{{store.id}}" >
				<button type="button" class="col-sm-3 col-sm-offset-1 btn btn-danger"><i class="fa fa-trash-o"></i></button>    
			</a>
			<div ng-if="$root.auth_permissions.delete.store" class="modal fade" id="myModal@{{store.id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h4 class="modal-title">Confirma</h4>
						</div>
						<div class="modal-body">

							¿Deseas eliminar la sucursal  <strong>@{{store.name}}</strong>?

						</div>
						<div class="modal-footer">                                        
							<form class="btn " method="POST" action = "@{{ store.url_delete }}">
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

<div class="panel" ng-if="storesP.length == 0">
	<div class="panel-body">
		<h3 class="text-center">No se encontraron sucursales.</h3>
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
            'library/js/ng/stores.js',
            'library/js/ng/stores.controllers.js',
            'library/js/ng/stores.services.js',
            'library/js/ng/users.filters.js',
            'library/js/ng/directives.js',
            'library/js/jquery-ui-1.9.2.custom.min.js' ,
            'library/assets/bootstrap-fileupload/bootstrap-fileupload.js',
    ]
    ]
    )


@stop