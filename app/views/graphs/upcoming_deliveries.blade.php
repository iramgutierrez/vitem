<!--work progress start-->
                      <section class="panel" ng-controller="UpcomingDeliveriesController">
                          <div class="panel-body progress-panel">
                              <div class="task-progress col-sm-12">
                                  <h1>Próximas entregas.</h1>
                              </div>
                          </div>
                          <div class="finishedProductsContent">
	                          <table class="table table-hover personal-task">
	                              <tbody>
	                              <tr>
	                              	<th>#</th>
	                              	<th>Destino</th>
	                              	<th>Chofer</th>
	                              	<th>Fecha</th>
	                              	<th></th>
	                              </tr>
	                              <tr ng-repeat="(k , delivery) in deliveries">
	                                  <td>@{{ k+1 }}</td>
	                                  <td>@{{delivery.destination.type | destination_types}}: @{{ delivery.destination.value_type }}</td>
	                                  <td>
	                                  	<a href="@{{delivery.employee.user.url_show}}">
	                                  		@{{delivery.employee.user.name}}
	                                  	</a>
	                                  </td>
	                                  <td>@{{delivery.delivery_date | date:'d MMMM' }}</td>
	                                  <td>
	                                  	<a href="@{{delivery.sale.url_show}}">
	                                      Ver venta
	                                    </a>
	                                  </td>
	                              </tr>
	                              <tr ng-if="!deliveries.length">
	                              	<td colspan="4" class="text-center"> <h3> No se encontraron resultados</h3></td>
	                              </tr>
	                              </tbody>
	                          </table>
                          </div>
                      </section>
                      <!--work progress end-->