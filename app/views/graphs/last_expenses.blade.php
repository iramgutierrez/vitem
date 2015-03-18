<!--work progress start-->
                      <section class="panel" ng-controller="LastExpensesController" ng-init="$root.generateAuthPermissions({{ Auth::user()->role_id }})" ng-show="$root.auth_permissions.read.expense">
                          <div class="panel-body progress-panel">
                              <div class="task-progress col-sm-12">
                                  <h1>Ultimos gastos</h1>
                              </div>
                          </div>
                          <div class="finishedProductsContent">
	                          <table class="table table-hover personal-task">
	                              <tbody>
	                              <tr>
	                              	<th>#</th>
	                              	<th>Concepto</th>
	                              	<th>Categoria</th>
	                              	<th ng-if="$root.auth_permissions.read.user" >Empleado</th>
	                              	<th ng-if="$root.auth_permissions.read.store" >Sucursal</th>
	                              	<th>Fecha</th>
	                              	<th></th>
	                              </tr>
	                              <tr ng-repeat="(k , expense) in expenses">
	                                  <td>@{{ k+1 }}</td>
	                                  <td>@{{expense.concept }}</td>
	                                  <td>@{{ expense.expense_type.name }}</td>
	                                  <td ng-if="$root.auth_permissions.read.user" >
	                                  	<a href="@{{expense.employee.user.url_show}}">
	                                    	@{{ expense.employee.user.name }}
	                                    </a>
	                                  </td>
	                                  <td ng-if="$root.auth_permissions.read.store" >@{{ expense.store.name }}</td>
	                                  <td>@{{ expense.date | date:'d MMMM'}}</td>
	                                  <td>
	                                  	<a href="@{{expense.url_show}}">
	                                    	Ver
	                                    </a>
	                                  </td>
	                              </tr>
	                              <tr ng-if="!expenses.length">
	                              	<td colspan="4" class="text-center"> <h3> No se encontraron resultados</h3></td>
	                              </tr>
	                              </tbody>
	                          </table>
                          </div>
                      </section>
                      <!--work progress end-->