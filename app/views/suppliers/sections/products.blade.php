<section class="panel" ng-show="tab == 'products' " ng-init="init({{ $supplier->id }})">

	<div class="panel">
			<div class="panel-body">
				<div ng-view></div>
				<header class="panel-heading col-sm-12">
					<h1 class="col-sm-3">Productos</h1>
				</header>    

				{{ Field::text(
				'', 
				'' , 
				[ 
				'class' => 'col-md-10' , 
				'addon-first' => '<i class="fa fa-search"></i>' , 
				'placeholder' => 'Busca por id, nombre, codigo o modelo.',
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
				<p class="col-sm-2"><span class="badge bg-success">@{{total}}</span> productos</p>        
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
						<th class="col-sm-1">
							<a href="" ng-click="sort = 'name'; reverse=!reverse">Nombre
								<span class="pull-right" >
									<i class="fa fa-sort" ng-if="sort != 'name' "></i>
									<i class="fa fa-sort-alpha-asc" ng-if=" sort == 'name' && reverse == false "></i>
									<i class="fa  fa-sort-alpha-desc" ng-if=" sort == 'name' && reverse == true "></i>
								</span>
							</a>
						</th>
						<th class="col-sm-1">
							<a href="" ng-click="sort = 'key'; reverse=!reverse">Código
								<span class="pull-right" >
									<i class="fa fa-sort" ng-if="sort != 'key' "></i>
									<i class="fa fa-sort-alpha-asc" ng-if=" sort == 'key' && reverse == false "></i>
									<i class="fa  fa-sort-alpha-desc" ng-if=" sort == 'key' && reverse == true "></i>
								</span>
							</a>
						</th>
						<th class="col-sm-1">
							<a href="" ng-click="sort = 'model'; reverse=!reverse">Modelo
								<span class="pull-right" >
									<i class="fa fa-sort" ng-if="sort != 'model' "></i>
									<i class="fa fa-sort-alpha-asc" ng-if=" sort == 'model' && reverse == false "></i>
									<i class="fa  fa-sort-alpha-desc" ng-if=" sort == 'model' && reverse == true "></i>
								</span>
							</a>
						</th>
						<!--<th class="col-sm-1" ng-if="$root.auth_permissions.read.supplier">
							<a href="" ng-click="sort = 'supplier.name'; reverse=!reverse">Proveedor
								<span class="pull-right" >
									<i class="fa fa-sort" ng-if="sort != 'supplier.name' "></i>
									<i class="fa fa-sort-alpha-asc" ng-if=" sort == 'supplier.name' && reverse == false "></i>
									<i class="fa  fa-sort-alpha-desc" ng-if=" sort == 'supplier.name' && reverse == true "></i>
								</span>
							</a>
						</th>-->
						<!--<th class="col-sm-1">
							<a class="col-sm-12" href="" ng-click="sort = 'status'; reverse=!reverse">Status
								<span class="pull-right" >
									<i class="fa fa-sort" ng-if="sort != 'status' "></i>
									<i class="fa fa-sort-alpha-asc" ng-if=" sort == 'status' && reverse == false "></i>
									<i class="fa  fa-sort-alpha-desc" ng-if=" sort == 'status' && reverse == true "></i>
								</span>
							</a>
						</th>-->
						<th class="col-sm-2"></th>
                </tr>
                <?php /*<tr>
                	<th></th>
                	<th></th>
                	<th ng-if="$root.auth_permissions.read.supplier"></th>
                	<th></th>
                	<th></th>
     
<th>
	<span class="">
		{{ Field::select(
		'', 
		$statuses,
		'' ,
		[ 
		'ng-model' => 'status',
		'ng-change' => 'search()'
		]
		) 
	}}
</span>
</th>
<th></th>
</tr> */ ?>
</thead>
<tbody ng-if="viewGrid == 'list'" >
	<tr class="gradeX" ng-repeat="product in productsP | orderBy:sort:reverse">
		<td>@{{ product.id }}</td>
		<td>@{{ product.name }}</td>
		<td>@{{ product.key }}</td>
		<td>@{{ product.model }}</td>
		<!--<td ng-if="$root.auth_permissions.read.supplier" ><a href="@{{ product.supplier.url_show }}" >@{{ product.supplier.name }}</a></td>-->
		<!--<td>@{{ product.status | booleanProduct }}</td>-->
		<td>
			<a href="@{{ product.url_show }}" ng-if="$root.auth_permissions.read.product">
				<button type="button" class="col-sm-3 btn btn-success"><i class="fa fa-eye"></i></button>
			</a>
			<a href="@{{ product.url_edit }}" ng-if="$root.auth_permissions.update.product">
				<button  type="button" class="col-sm-3 col-sm-offset-1 btn btn-info "><i class="fa fa-refresh"></i></button>
			</a>
			<a data-toggle="modal" href="#myModal@{{product.id}}" ng-if="$root.auth_permissions.delete.product">
				<button type="button" class="col-sm-3 col-sm-offset-1 btn btn-danger"><i class="fa fa-trash-o"></i></button>    
			</a>
			<div ng-if="$root.auth_permissions.delete.product" class="modal fade" id="myModal@{{product.id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h4 class="modal-title">Confirma</h4>
						</div>
						<div class="modal-body">

							¿Deseas eliminar el producto <strong>@{{product.name}}</strong>?

						</div>
						<div class="modal-footer">
							<button data-dismiss="modal" class="btn btn-default" type="button">Regresar</button>                                              
							<form class="btn " method="POST" action = "@{{ product.url_delete }}">
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


</section>