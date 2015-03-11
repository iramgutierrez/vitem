<!--work progress start-->
                      <section class="panel" ng-controller="FinishedProductsController">
                          <div class="panel-body progress-panel">
                              <div class="task-progress col-sm-12">
                                  <h1>Productos agotados o próximos a agotarse</h1>
                              </div>
                          </div>
                          <div class="finishedProductsContent">
	                          <table class="table table-hover personal-task">
	                              <tbody>
	                              <tr>
	                              	<th>#</th>
	                              	<th>Producto</th>
	                              	<th>Cantidad</th>
	                              	<!--<th>Realizar pedido</th>-->
	                              </tr>
	                              <tr ng-repeat="(k , product) in products">
	                                  <td>@{{ k+1 }}</td>
	                                  <td>
	                                  	<a href="@{{product.url_show}}">
	                                      @{{product.name }}
	                                    </a>
	                                  </td>
	                                  <td>
	                                      <span class="badge bg-success">@{{ product.stock }}</span>
	                                  </td>
	                                  <!--<td>
	                                  	<a href="@{{product.supplier.url_show}}">
	                                      <button type="button" class="pull-right btn"><i class="fa fa-edit"></i></button>
	                                    </a>
	                                  </td>-->
	                              </tr>
	                              <tr ng-if="!products.length">
	                              	<td colspan="4" class="text-center"> <h3> No se encontraron resultados</h3></td>
	                              </tr>
	                              </tbody>
	                          </table>
                          </div>
                      </section>
                      <!--work progress end-->