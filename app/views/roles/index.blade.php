@extends('layout')

@section('header')

    @include('header' )

@stop

@section('sidebar_left')

    @include('sidebar_left')

@stop

@section('content')




<div ng-app="roles" >

<div class="adv-table" ng-controller="RolesController">
<div class="panel">
    <div class="panel-body">
        <div ng-view></div>
        <header class="panel-heading col-sm-12">
            <h1 class="col-sm-3">Roles</h1>
            <a href="{{ route('roles.create') }}"><button type="button" class="pull-right btn btn-success ">Agregar rol</button></a>
        </header>    
   
        {{ Field::text(
                '', 
                '' , 
                [ 
                    'class' => 'col-md-10' , 
                    'addon-first' => '<i class="fa fa-search"></i>' , 
                    'placeholder' => 'Busca por id o nombre.',
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
            <p class="col-sm-2"><span class="badge bg-success">@{{roles.length}}</span> roles</p>        
            <button type="button" ng-click="clear()" class="pull-right btn btn-info">Limpiar filtros</button>
        </div>
        <div class="clearfix"></div>
        <hr>
        <table  class="display table table-bordered table-striped col-sm-12" id="dynamic-table" >
            <thead>
                <tr >
                    <th class="col-sm-1" rowspan="2" >                        
                        <a href="" ng-click="sort = 'id'; reverse=!reverse">Id
                            <span class="pull-right" >
                                <i class="fa fa-sort" ng-if="sort != 'id' "></i>
                                <i class="fa fa-sort-numeric-asc" ng-if=" sort == 'id' && reverse == false "></i>
                                <i class="fa  fa-sort-numeric-desc" ng-if=" sort == 'id' && reverse == true "></i>
                            </span>
                        </a>
                    </th>
                    <th class="col-sm-1" rowspan="2" >
                        <a href="" ng-click="sort = 'name'; reverse=!reverse">Nombre
                            <span class="pull-right" >
                                <i class="fa fa-sort" ng-if="sort != 'name' "></i>
                                <i class="fa fa-sort-alpha-asc" ng-if=" sort == 'name' && reverse == false "></i>
                                <i class="fa  fa-sort-alpha-desc" ng-if=" sort == 'name' && reverse == true "></i>
                            </span>
                        </a>
                    </th>
                    <th class="col-sm-1" rowspan="2" >
                        <a href="" ng-click="sort = 'level_id'; reverse=!reverse">Nivel
                            <span class="pull-right" >
                                <i class="fa fa-sort" ng-if="sort != 'level_id' "></i>
                                <i class="fa fa-sort-alpha-asc" ng-if=" sort == 'level_id' && reverse == false "></i>
                                <i class="fa  fa-sort-alpha-desc" ng-if=" sort == 'level_id' && reverse == true "></i>
                            </span>
                        </a>
                    </th>
                    <th class="col-sm-1" rowspan="2" >
                   	</th>
                    <th  class="col-sm-7 text-center" colspan="@{{ entities.length }}">
                    	Entidades
                    </th>
                    <th class="col-sm-3" rowspan="2" >
                   	</th>
                </tr>
                <tr style="height: 150px; ">
                    <th ng-repeat="entity in entities" style="vertical-align: top; ">
                        <p style="width: 5px !important;    transform: rotate(90deg); height: 20px;">
                    	 @{{ entity.spanish_name }}

                        </p>
                    </th>
                </tr>
            </thead>
            <tbody ng-if="viewGrid == 'list'"  ng-repeat="role in rolesP | orderBy:sort:reverse">
                <tr class="gradeX">
                    <td rowspan="5" >@{{ role.id }}</td>
                    <td rowspan="5" >@{{ role.name }}</td>
                    <td rowspan="5" >@{{ role.level_id }}</td>
                </tr>
	                    	<tr ng-repeat="action in actions">
		                    	<td>
		                    		@{{ action.spanish_name }}
		                    	</td>
		                    	<td ng-repeat="entity in entities" >

			                    	<span ng-if="checkPermission(role.permission , entity.id , action.id)" >

			                    			<i class="fa fa-check-circle"></i>

			                    	</span>

			                    </td>
			                    <td ng-if="$first" rowspan="4">
			                        <a href="@{{ role.url_show }}" >
			                            <button type="button" class="col-sm-3 btn btn-success"><i class="fa fa-eye"></i></button>
			                        </a>
			                        <a href="@{{ role.url_edit }}" >
			                            <button  type="button" class="col-sm-3 col-sm-offset-1 btn btn-info "><i class="fa fa-refresh"></i></button>
			                        </a>
			                        <a data-toggle="modal" href="#myModal@{{role.id}}" >
			                            <button type="button" class="col-sm-3 col-sm-offset-1 btn btn-danger"><i class="fa fa-trash-o"></i></button>    
			                        </a>
			                              <div class="modal fade" id="myModal@{{role.id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			                                  <div class="modal-dialog">
			                                      <div class="modal-content">
			                                          <div class="modal-header">
			                                              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			                                              <h4 class="modal-title">Confirma</h4>
			                                          </div>
			                                          <div class="modal-body">

			                                              ¿Deseas eliminar el rol <strong>@{{role.name }}</strong>?

			                                          </div>
			                                          <div class="modal-footer">
			                                              <button data-dismiss="modal" class="btn btn-default" type="button">Regresar</button>                                              
			                                                <form class="btn " method="POST" action = "@{{ role.url_delete }}">
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

        <div class="panel" ng-if="suppliersP.length == 0">
            <div class="panel-body">
                <h3 class="text-center">No se encontraron roles.</h3>
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
                  				'library/js/jquery-ui-1.9.2.custom.min.js' ,
                                'library/js/ng/roles.js',
                                'library/js/ng/roles.controllers.js',
                                'library/js/ng/roles.services.js',
                                'library/js/ng/users.filters.js',
                                'library/js/ng/users.directives.js'
    							]
    				   ]
    		)

@stop