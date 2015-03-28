<!--work progress start-->
                      <section class="panel" ng-controller="FinishedProductsController" ng-show="$root.auth_permissions.read.product">
                          <div class="panel-body progress-panel">
                              <div class="task-progress col-sm-12">
                                  <h1>Productos agotados o próximos a agotarse</h1>
                              </div>
                          </div>
                          <div class="finishedProductsContent">
	                          <table class="table table-hover">
	                              <tbody>
	                              <tr>
	                              	<th class="col-sm-2 text-center" >#</th>
	                              	<th class="col-sm-2 text-center" >Producto</th>
	                              	<th class="col-sm-2 text-center" >Cantidad en almacen</th>
	                              	<th class="col-sm-2 text-center" >
	                              		Cantidad en sucursal

	                              		@if(Auth::user()->role->level_id >= 3)

		                              		@if(Session::has('current_store'))

		                              			<span ng-init="store_id = {{ Session::get('current_store')['id'] }}; getProducts();" ></span>

		                              		@else
		                              		
			                              		{{ 

														Field::select(
												    		'', 
												      		$stores,
												      		'' ,
														      [ 
														      	'class' => 'col-sm-6' ,

													            'ng-model' => 'store_id',

													            'ng-change' => 'getProducts()',

																'ng-init' => 'store_id = 0; getProducts();',


														      ]
												    ) 
											    
											    }}

										    @endif

									    @else

									    <span ng-init="store_id = {{ Auth::user()->store_id }}; getProducts();" ></span>

									    @endif
	                              	</th>
	                              	<th class="col-sm-2 text-center" ng-if="$root.auth_permissions.update.product">Editar producto</th>
	                              	<th class="col-sm-2 text-center" ng-if="$root.auth_permissions.create.order">Realizar pedido</th>
	                              </tr>
	                              <tr ng-repeat="(k , product) in products | orderBy:sort:reverse">
	                                  <td class="text-center" >@{{ k+1 }}</td>
	                                  <td class="text-center" >
	                                  	<a href="@{{product.url_show}}">
	                                      @{{product.name }}
	                                    </a>
	                                  </td>
	                                  <td class="text-center">
	                                      <span class="badge bg-success">@{{ product.stock }}</span>
	                                  </td>
	                                  <td class="text-center">
	                                      <span class="badge bg-success">@{{ product.stock_store }}</span>
	                                  </td>
	                                  <td class="text-center"  ng-if="$root.auth_permissions.update.product">
	                                  	<a href="@{{product.url_edit}}">
	                                      <button type="button" class="btn btn-success"><i class="fa fa-edit"></i> Editar producto</button>
	                                    </a>
	                                  </td>
	                                  <td class="text-center"  ng-if="$root.auth_permissions.create.order">
	                                  	<a href="{{ route('orders.create.supplier_id' ) }}/@{{ product.supplier_id }}/@{{ product.id }}">
	                                      <button type="button" class="btn"><i class="fa fa-edit"></i> Realizar pedido</button>
	                                    </a>
	                                  </td>
	                              </tr>
	                              <tr ng-if="!products.length">
	                              	<td colspan="4" class="text-center"> <h3> No se encontraron resultados</h3></td>
	                              </tr>
	                              </tbody>
	                          </table>
                          </div>
                      </section>
                      <!--work progress end-->