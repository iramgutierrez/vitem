<section class="panel" ng-show="$root.auth_permissions.read.sale && tab == 'ventas' ">
	<div >
		<div class="adv-table">
			<div class="panel">
				<div class="panel-body">
					<div ng-view></div>
					<header class="panel-heading col-sm-12">
						<h1 class="col-sm-3">Ventas</h1>
					</header>

					{{ Field::text(
					  '',
					  '' ,
					  [
						  'class' => 'col-md-10' ,
						  'addon-first' => '<i class="fa fa-search"></i>' ,
						  'placeholder' => 'Busca por id, folio o cliente.',
						  'ng-model' => 'find',
						  'ng-change' => 'search()',

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
							<th class="col-sm-1" ng-if="$root.auth_permissions.read.user">
								<a href="" ng-click="sort = 'client.name'; reverse=!reverse">Empleado
                                          <span class="pull-right" >
                                            <i class="fa fa-sort" ng-if="sort != 'client.name' "></i>
                                            <i class="fa fa-sort-alpha-asc" ng-if=" sort == 'client.name' && reverse == false "></i>
                                            <i class="fa  fa-sort-alpha-desc" ng-if=" sort == 'client.name' && reverse == true "></i>
                                          </span>
								</a>
							</th>
							<th class="col-sm-1">
								<a href="" ng-click="sort = 'sale_date'; reverse=!reverse">Fecha de venta
                                          <span class="pull-right" >
                                            <i class="fa fa-sort" ng-if="sort != 'sale_date' "></i>
                                            <i class="fa fa-sort-numeric-asc" ng-if=" sort == 'sale_date' && reverse == false "></i>
                                            <i class="fa  fa-sort-numeric-desc" ng-if=" sort == 'sale_date' && reverse == true "></i>
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
							<th class="col-sm-1">
								<a href="" ng-click="sort = 'pay_type'; reverse=!reverse">Forma de pago
                                          <span class="pull-right" >
                                            <i class="fa fa-sort" ng-if="sort != 'pay_type' "></i>
                                            <i class="fa fa-sort-alpha-asc" ng-if=" sort == 'pay_type' && reverse == false "></i>
                                            <i class="fa  fa-sort-alpha-desc" ng-if=" sort == 'pay_type' && reverse == true "></i>
                                          </span>
								</a>
							</th>
							<th class="col-sm-2" ng-if="$root.auth_permissions.read.commission">Comisiones</th>
							<th class="col-sm-2"></th>
						</tr>
						<tr>
							<th></th>
							<th ng-if="$root.auth_permissions.read.user" ></th>
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
						<tbody >
						<tr class="gradeX" ng-repeat="sale in salesP | orderBy:sort:reverse">
							<td>@{{ sale.id }}</td>
							<td ng-if="$root.auth_permissions.read.user"><a href="@{{ sale.employee.user.url_show }}">@{{ sale.employee.user.name }}</td>
							<td>@{{ sale.sale_date }}</td>
							<td>@{{ sale.sale_type }}</td>
							<td>@{{ sale.pay_type.name }}</td>
							<td ng-if="$root.auth_permissions.read.commission">
								@{{ sale.commissions.length }}
								<a ng-if="$root.auth_permissions.create.commission" href="{{ route('commissions.create' ) }}/@{{ sale.id }}/@{{ sale.employee_id }}">
									<button type="button" class="pull-right btn btn-success ">
										<i class="fa fa-plus"></i>
									</button>
								</a>
							</td>
							<td>
								<a href="@{{ sale.url_show }}" ng-if="$root.auth_permissions.read.sale">
									<button type="button" class="col-sm-3 btn btn-success"><i class="fa fa-eye"></i></button>
								</a>
								<a href="@{{ sale.url_edit }}"  ng-if="$root.auth_permissions.update.sale" >
									<button  type="button" class="col-sm-3 col-sm-offset-1 btn btn-info "><i class="fa fa-refresh"></i></button>
								</a>
								<a data-toggle="modal" href="#myModal@{{sale.id}}"  ng-if="$root.auth_permissions.delete.sale" >
									<button type="button" class="col-sm-3 col-sm-offset-1 btn btn-danger"><i class="fa fa-trash-o"></i></button>
								</a>
								<div class="modal fade" id="myModal@{{sale.id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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

		</div>
	</div>
</section>