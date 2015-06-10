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
<div   ng-app="expense_types" >
<div class="adv-table" ng-controller="ExpenseTypesController" ng-init="$root.generateAuthPermissions({{ Auth::user()->role_id }})" >
<div class="panel">
    <div class="panel-body">
        <div ng-view></div>
        <header class="panel-heading col-sm-12">
            <button ng-show="$root.auth_permissions.create.expense_type" ng-click="newExpenseType()" type="button" class="pull-right btn btn-success ">Agregar tipo de gasto</button>
            <h1 class="col-sm-12">Tipos de gastos</h1>
        </header>

        <div ng-show="new">

        	{{ Form::model( new ExpenseType ,['route' => 'expense_types.store',  'name' => 'addexpensetypeForm' , 'method' => 'POST', 'class' => 'form-inline' ,'role' => 'form', 'novalidate' , 'ng-submit' => 'addExpenseType($event , addexpensetypeForm.$valid)', 'enctype' =>  'multipart/form-data' ]) }}
            
                {{ Field::hidden(
                            'id', 
                            '' , 
                            [ 
                                'class' => 'col-md-10' ,
                                'ng-model' => 'id',
                                'ng-value' => 'id'

                            ]
                        ) 
                    }}  

	            <div class=" form-group col-sm-6">

	            	{{ Field::text(
			                'name', 
			                '' , 
			                [ 
			                    'class' => 'col-md-10' ,
			                    'ng-model' => 'name',
			                    'required'

			                ]
			            ) 
			        }}			        

		            <div ng-show="addexpensetypeForm.submitted || addexpensetypeForm.name.$touched">

		                <label for="name" class="error" ng-show="addexpensetypeForm.name.$error.required">

		                    Debes ingresar un nombre.

		                </label>

		            </div>

	            </div> 

	            <div class="form-group col-sm-3 col-sm-offset-9 text-right">       

	            	<button type="button" class="btn btn-danger" ng-click="new = false">Cancelar</button>                           	 
	            
	            	<button type="submit" class="btn btn-success">@{{ button }}</button>
	                
	            </div>
	            
            {{ Form::close() }}            		
                              		
        	
        </div>

        <div class="clearfix"></div>
        <div class="col-sm-12">
            <p class="col-sm-2"><span class="badge bg-success">@{{expense_types.length}}</span> tipos de gastos</p>      
        </div>
        <div class="clearfix"></div>
        <hr>
        <table  class="display table table-bordered table-striped col-sm-12" id="dynamic-table" >
            <thead>
                <tr >
                    <th class="col-sm-3">                        
                        <a href="" ng-click="sort = 'id'; reverse=!reverse">Id
                            <span class="pull-right" >
                                <i class="fa fa-sort" ng-if="sort != 'id' "></i>
                                <i class="fa fa-sort-alpha-asc" ng-if=" sort == 'id' && reverse == false "></i>
                                <i class="fa  fa-sort-alpha-desc" ng-if=" sort == 'id' && reverse == true "></i>
                            </span>
                        </a>
                    </th>
                    <th class="col-sm-3">
                        <a href="" ng-click="sort = 'name'; reverse=!reverse">Nombre
                            <span class="pull-right" >
                                <i class="fa fa-sort" ng-if="sort != 'name' "></i>
                                <i class="fa fa-sort-alpha-asc" ng-if=" sort == 'name' && reverse == false "></i>
                                <i class="fa  fa-sort-alpha-desc" ng-if=" sort == 'name' && reverse == true "></i>
                            </span>
                        </a>
                    </th>
                    <th class="col-sm-3"></th>
            </thead>
            <tbody >
                <tr class="gradeX" ng-repeat="(k,expense_type) in expense_types | orderBy:sort:reverse">
                    <td>@{{ expense_type.id }}</td>
                    <td>@{{ expense_type.name }}</td>
                    <td>
                        <a ng-click="updateExpenseType(k , expense_type)" ng-if="$root.auth_permissions.update.expense_type" >
                            <button  type="button" class="col-sm-3 col-sm-offset-1 btn btn-info "><i class="fa fa-refresh"></i></button>
                        </a>
                        <a data-toggle="modal" href="#myModal@{{expense_type.id}}" ng-if="$root.auth_permissions.delete.expense_type">
                            <button type="button" class="col-sm-3 col-sm-offset-1 btn btn-danger"><i class="fa fa-trash-o"></i></button>    
                        </a>
                              <div ng-if="$root.auth_permissions.delete.expense_type" class="modal fade" id="myModal@{{expense_type.id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                  <div class="modal-dialog">
                                      <div class="modal-content">
                                          <div class="modal-header">
                                              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                              <h4 class="modal-title">Confirma</h4>
                                          </div>
                                          <div class="modal-body">

                                              ¿Deseas eliminar el tipo de gasto <strong>@{{expense_type.name}}</strong>?

                                          </div>
                                          <div class="modal-footer">
                                              <button data-dismiss="modal" class="btn btn-default" type="button">Regresar</button>                                              
                                                <form class="btn " method="POST" action = "@{{ expense_type.url_delete }}">
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

        <div class="panel" ng-if="destinationsP.length == 0">
        	<div class="panel-body">
				<h3 class="text-center">No se encontraron tipos de gastos.</h3>
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
                                'library/js/ng/expense_types.js',
                                'library/js/ng/expense_types.controllers.js',
                                'library/js/ng/expense_types.services.js',
                                'library/js/jquery-ui-1.9.2.custom.min.js' 
    							]
    				   ]
    		)

@stop