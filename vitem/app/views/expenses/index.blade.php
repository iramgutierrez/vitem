@extends('layout')

@section('header')

    @include('header' , [ 'css' => [
    								'library/assets/bootstrap-datepicker/css/datepicker.css',
    								'library/assets/bootstrap-colorpicker/css/colorpicker.css',
    								'library/assets/bootstrap-daterangepicker/daterangepicker.css',
                    'library/assets/bootstrap-fileupload/bootstrap-fileupload.css'
    							   ]
    					]
    		)

@stop

@section('sidebar_left')

    @include('sidebar_left')

@stop

@section('content')
<div   ng-app="expenses" >
<div class="adv-table" ng-controller="ExpensesController">
<div class="panel">
    <div class="panel-body">
        <div ng-view></div>
        <header class="panel-heading col-sm-12">
            <h1 class="col-sm-3">Gastos</h1>
            <a href="{{ route('expenses.create') }}"><button type="button" class="pull-right btn btn-success ">Agregar gasto</button></a>
        </header>
    
   
        {{ Field::text(
                '', 
                '' , 
                [ 
                    'class' => 'col-md-10' , 
                    'addon-first' => '<i class="fa fa-search"></i>' , 
                    'placeholder' => 'Busca por empleado, concepto o descripción',
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
            <p class="col-sm-2"><span class="badge bg-success">@{{expenses.length}}</span> gastos</p>        
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
                                <i class="fa fa-sort-alpha-asc" ng-if=" sort == 'id' && reverse == false "></i>
                                <i class="fa  fa-sort-alpha-desc" ng-if=" sort == 'id' && reverse == true "></i>
                            </span>
                        </a>
                    </th>
                    <th class="col-sm-1">
                        <a href="" ng-click="sort = 'expense_type.name'; reverse=!reverse">Tipo
                            <span class="pull-right" >
                                <i class="fa fa-sort" ng-if="sort != 'expense_type.name' "></i>
                                <i class="fa fa-sort-alpha-asc" ng-if=" sort == 'expense_type.name' && reverse == false "></i>
                                <i class="fa  fa-sort-alpha-desc" ng-if=" sort == 'expense_type.name' && reverse == true "></i>
                            </span>
                        </a>
                    </th>
                    <th class="col-sm-2">
                        <a href="" ng-click="sort = 'employee.user.name'; reverse=!reverse">Empleado
                            <span class="pull-right" >
                                <i class="fa fa-sort" ng-if="sort != 'employee.user.name' "></i>
                                <i class="fa fa-sort-alpha-asc" ng-if=" sort == 'employee.user.name' && reverse == false "></i>
                                <i class="fa  fa-sort-alpha-desc" ng-if=" sort == 'employee.user.name' && reverse == true "></i>
                            </span>
                        </a>
                    </th>
                    <th class="col-sm-2">
                        <a href="" ng-click="sort = 'date'; reverse=!reverse">Fecha
                            <span class="pull-right" >
                                <i class="fa fa-sort" ng-if="sort != 'date' "></i>
                                <i class="fa fa-sort-alpha-asc" ng-if=" sort == 'date' && reverse == false "></i>
                                <i class="fa  fa-sort-alpha-desc" ng-if=" sort == 'date' && reverse == true "></i>
                            </span>
                        </a>
                    </th>
                    <th class="col-sm-2">
                        <a href="" ng-click="sort = 'quantity'; reverse=!reverse">Cantidad
                            <span class="pull-right" >
                                <i class="fa fa-sort" ng-if="sort != 'quantity' "></i>
                                <i class="fa fa-sort-alpha-asc" ng-if=" sort == 'quantity' && reverse == false "></i>
                                <i class="fa  fa-sort-alpha-desc" ng-if=" sort == 'quantity' && reverse == true "></i>
                            </span>
                        </a>
                    </th>
                    <th class="col-sm-2"></th>
                    <!--<th class="hidden-phone">Nombre de destino</th>
                    <th class="hidden-phone"></th>-->
                </tr>
                <tr>
                    <th></th>
                    <th>
                        <span class="">
                            {{ Field::select(
                                                        '', 
                                                        $types,
                                                        '' ,
                                                        [ 
                                                            'ng-model' => 'type',
                                                            'ng-change' => 'search()'
                                                        ]
                                                ) 
                                        }}
                        </span>
                    </th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody ng-if="viewGrid == 'list'" >
                <tr class="gradeX" ng-repeat="expense in expensesP | orderBy:sort:reverse">
                    <td>@{{ expense.id }}</td>
                    <td>@{{ expense.expense_type.name }}</td>
                    <td>@{{ expense.employee.user.name }}</td>
                    <td>@{{ expense.date }}</td>
                    <td>@{{ expense.quantity | currency }}</td>
                    <td>
                        <a href="@{{ expense.url_show }}" >
                            <button type="button" class="col-sm-3 btn btn-success"><i class="fa fa-eye"></i></button>
                        </a>
                        <a href="@{{ expense.url_edit }}" >
                            <button  type="button" class="col-sm-3 col-sm-offset-1 btn btn-info "><i class="fa fa-refresh"></i></button>
                        </a>
                        <a data-toggle="modal" href="#myModal@{{expense.id}}" >
                            <button type="button" class="col-sm-3 col-sm-offset-1 btn btn-danger"><i class="fa fa-trash-o"></i></button>    
                        </a>
                              <div class="modal fade" id="myModal@{{expense.id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                  <div class="modal-dialog">
                                      <div class="modal-content">
                                          <div class="modal-header">
                                              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                              <h4 class="modal-title">Confirma</h4>
                                          </div>
                                          <div class="modal-body">

                                              ¿Deseas eliminar el gasto de <strong>@{{expense.quantity | currency }}</strong>?

                                          </div>
                                          <div class="modal-footer">
                                              <button data-dismiss="modal" class="btn btn-default" type="button">Regresar</button>                                              
                                                <form class="btn " method="POST" action = "@{{ expense.url_delete }}">
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

        <div class="panel" ng-if="expensesP.length == 0">
        	<div class="panel-body">
				<h3 class="text-center">No se encontraron gastos.</h3>
        	</div>
        </div>

        <div class="directory-info-row" ng-if="viewGrid == 'details'">
              <div class="row">
              <div class="col-md-6 col-sm-6 clearfix"  ng-repeat="expense in expensesP | orderBy:sort:reverse">
                  <div class="panel">
                      <div class="panel-body">
                          <div class="media">
                              <a class="pull-left" href="@{{ expense.url_show }}">
                                  <img class="thumb media-object" src="@{{ expense.image_profile_url }}" alt="">
                              </a>
                              <div class="media-body">
                                  <h4> Costo: @{{ expense.cost | currency }} </h4>
                                  <!--<ul class="social-links">
                                      <li><a title="" data-placement="top" data-toggle="tooltip" class="tooltips" href="" data-original-title="Facebook"><i class="fa fa-facebook"></i></a></li>
                                      <li><a title="" data-placement="top" data-toggle="tooltip" class="tooltips" href="" data-original-title="Twitter"><i class="fa fa-twitter"></i></a></li>
                                      <li><a title="" data-placement="top" data-toggle="tooltip" class="tooltips" href="" data-original-title="LinkedIn"><i class="fa fa-linkedin"></i></a></li>
                                      <li><a title="" data-placement="top" data-toggle="tooltip" class="tooltips" href="" data-original-title="Skype"><i class="fa fa-skype"></i></a></li>
                                  </ul><br>-->
                                  <address>
                                      
                                      <strong>Tipo: @{{ expense.expense_type.name }}</strong><br>
                                        <span ng-if="expense.employee.user.name != ''">Empleado: &nbsp;@{{ expense.employee.user.name }}<br></span>
                                        <span ng-if="expense.date != ''">Fecha: &nbsp;@{{ expense.date }}<br></span>
                                        <span ng-if="expense.quantity != ''">Cantidad: &nbsp;@{{ expense.quantity | currency }}<br></span>
                                  </address>
                                  <div class="col-sm-6 pull-right">

                                  <a href="@{{ expense.url_show }}" class="col-sm-4" >
                            <button type="button" class=" btn btn-success"><i class="fa fa-eye"></i></button>
                        </a>
                        <a href="@{{ expense.url_edit }}" class="col-sm-4" >
                            <button  type="button" class="col-sm-offset-1 btn btn-info "><i class="fa fa-refresh"></i></button>
                        </a>
                        <a data-toggle="modal" href="#myModalD@{{expense.id}}" class="col-sm-4" >
                            <button type="button" class="col-sm-offset-1 btn btn-danger"><i class="fa fa-trash-o"></i></button>    
                        </a>
                              <div class="modal fade" id="myModalD@{{expense.id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                  <div class="modal-dialog">
                                      <div class="modal-content">
                                          <div class="modal-header">
                                              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                              <h4 class="modal-title">Confirma</h4>
                                          </div>
                                          <div class="modal-body">

                                              ¿Deseas eliminar el gasto de <strong>@{{expense.quantity | currency }}</strong>?

                                          </div>
                                          <div class="modal-footer">
                                              <button data-dismiss="modal" class="btn btn-default" type="button">Regresar</button>                                              
                                                <form class="btn " method="POST" action = "@{{ expense.url_delete }}">
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
			                'library/js/ng/expenses.js',
			                'library/js/ng/expenses.controllers.js',
			                'library/js/ng/expenses.services.js',
			                'library/js/ng/users.services.js',
			                'library/js/ng/users.filters.js',
		        		    'library/js/ng/ng-date.js',
                  			'library/js/jquery-ui-1.9.2.custom.min.js' ,
                  			'library/js/bootstrap-switch.js' ,
                  			'library/js/jquery.tagsinput.js' ,
                  			'library/js/ga.js' ,
    							]
    				   ]
    		)

@stop