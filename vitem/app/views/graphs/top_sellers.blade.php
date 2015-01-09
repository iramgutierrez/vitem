<!--work progress start-->
                      <section class="panel" ng-controller="TopSellersController">
                          <div class="panel-body progress-panel">
                              <div class="task-progress col-sm-6">
                                  <h1>Mejores vendedores</h1>
                              </div>
								<div class="col-sm-6">

									{{ Field::select
										(
											'show_by', 
											[
												'total_sales' => 'Por número de ventas',
												'total' => 'Por total vendido'
											],
											null ,
											[	                
								                'ng-model' => 'type',
								                'ng-change' => 'getTop()'
								            ]
										) 
									}}   

								</div><br>
                              <div class="task-option col-sm-12 pull-right">

                              	<div class="col-sm-6" >

							        {{ Field::date

										(
											'init_date', 
											'' ,
											[ 	                
								                'ng-model' => 'initDate',
		                'ng-init' => 'setDates('.date('Y , m , d' , time() - (60*60*24*30)).' , '.date('Y , m , d' , ( time()  ) ).')',
								                'ng-change' => 'getTop()'
								            ]
										) 
									}} 

								</div>

								<div class="col-sm-6" >

							        {{ Field::date

										(
											'end_date', 
											'' ,
											[ 	                
								                'ng-model' => 'endDate',
								                'ng-change' => 'getTop()'
								            ]
										) 
									}} 

								</div>
                              </div>
                          </div>
                          <table class="table table-hover personal-task">
                              <tbody>
                              <tr>
                              	<th>#</th>
                              	<th>Vendedor</th>
                              	<th>Total de ventas</th>
                              	<th>Cantidad total</th>
                              </tr>
                              <tr ng-repeat="(k , seller) in sellers">
                                  <td>@{{ k+1 }}</td>
                                  <td>
                                  	<a href="@{{seller.employee.user.url_show}}">
                                      @{{seller.employee.user.name }}
                                    </a>
                                  </td>
                                  <td>
                                      <span class="badge bg-success">@{{ seller.total_sales }}</span>
                                  </td>
                                  <td>
                                      <span class="badge bg-warning">@{{ seller.total | currency }}</span>
                                  </td>
                              </tr>
                              <tr ng-if="!sellers.length">
                              	<td colspan="4" class="text-center"> <h3> No se encontraron resultados</h3></td>
                              </tr>
                              </tbody>
                          </table>
                      </section>
                      <!--work progress end-->