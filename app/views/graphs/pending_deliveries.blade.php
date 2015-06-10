<!--work progress start-->
                      <section class="panel" ng-controller="PendingDeliveriesController" ng-init="$root.generateAuthPermissions({{ Auth::user()->role_id }})" ng-show="$root.auth_permissions.read.sale && $root.auth_permissions.read.delivery">
                          <div class="panel-body progress-panel">
                              <div class="task-progress col-sm-12">
                                  <h1>Ventas con entrega pendiente.</h1>
                              </div>
                          </div>
                          <div class="finishedProductsContent">
	                          <table class="table table-hover personal-task">
	                              <tbody>
	                              <tr>
	                              	<th>#</th>
	                              	<th>Id de venta</th>
	                              	<th>Fecha</th>
	                              	<th ng-show="$root.auth_permissions.read.store">Sucursal</th>
	                              	<th></th>
	                              </tr>
	                              <tr ng-repeat="(k , sale) in sales">
	                                  <td>@{{ k+1 }}</td>
	                                  <td>@{{ sale.id }}</td>
	                                  <td>@{{sale.sale_date | date:'d MMMM' }}</td>
	                                  <td ng-show="$root.auth_permissions.read.store" >@{{ sale.store.name }}</td>
	                                  <td>
	                                  	<a href="{{ route('deliveries.create')}}/@{{sale.id}}">
	                                      Agregar entrega
	                                    </a>
	                                  </td>
	                              </tr>
	                              <tr ng-if="!sales.length">
	                              	<td colspan="4" class="text-center"> <h3> No se encontraron resultados</h3></td>
	                              </tr>
	                              </tbody>
	                          </table>
                          </div>
                      </section>
                      <!--work progress end-->