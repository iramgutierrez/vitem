@extends('layout')

@section('header')

     @include('header' , [ 'css' => [
                    				'library/css/bootstrap-switch.css'
    							   ]
    					]
    		)

@stop

@section('sidebar_left')

    @include('sidebar_left')

@stop

@section('content')




<div ng-app="roles" >

<div class="adv-table" >

<div class="panel">
    
    <div class="panel-body">

    	{{ Form::model( $role->toArray() , ['route' => ['roles.update', $role->id] , 'method' => 'PATCH' , 'class' => 'form-inline' ,'role' => 'form', 'novalidate' , 'ng-controller' => 'EditController' , 'ng-init' => 'getRole('.$role->id.')'  ]) }}

        
        <header class="panel-heading col-sm-12">
        
            <h1 class="col-sm-3">Editar rol</h1>
        
        </header>  
        <div class="clearfix"></div>
        <br>

        {{ 
        	Field::text(
               'name', 
                null , 
                [ 
             	   'class' => 'col-md-12' ,
                   'placeholder' => 'Ingresa el nombre'
                ]
            ) 
        }}

        <div class="clearfix"></div>



        <h2>Nivel</h2>

        {{-- <div class="col-sm-6">

            {{
                Field::select(
                   'visibility',
                    [
                        'self' => 'Solo las acciones del usuario' ,
                        'equal' => 'Acciones de usuarios del mismo nivel' ,
                        'less' => 'Acciones de usuarios de menor nivel',
                        'equal_less' => 'Acciones de usuarios del mismo o menor nivel',
                        'all' => 'Acciones de todos los usuarios'
                    ],
                    null ,
                    [
                       'class' => 'col-md-12',
                       'ng-model' => 'visibility',
                       'ng-change' => 'checkLevel()'
                    ]
                )
            }}

        </div> --}}

        <div class="col-sm-12">



            <ul id="sortable2" >
                @foreach($levels as  $level)
                    <li class="ui-state-default ui-state-disabled" ng-class="{current_level : current_level == {{ $level->id }} }" ng-click="current_level = {{ $level->id }}">
                        {{ $level->id }} - {{ $level->description }}
                        {{--}}@foreach($level->role as $rk => $role)
                            {{ $role->name }}
                            @if($rk < count($level->role) - 1 )
                                ,
                            @endif

                        @endforeach--}}



                    </li>
                @endforeach

            </ul>

            {{

                Field::hidden(
                    'level_id',
                    $role->level_id,
                    [
                        'ng-model' => 'current_level',
                        'ng-value' => 'current_level',
                        'ng-init' => 'current_level = '.$role->level_id,
                    ]
                )
            }}

        </div>


        <br>
        <table  class="display table table-bordered table-striped col-sm-12" id="dynamic-table"  
        ng-init="

        @if(isset(Input::old()['Permission']))

            @foreach( Input::old()['Permission'] as $action => $entities)

                @foreach($entities as $entity => $value)

                    permissions[{{$action}}][{{$entity}}] = true;

                @endforeach

            @endforeach

        @endif"
        >
            <thead>
                <tr>
                    <th class="col-sm-1"> 
                    </th>
                    <th ng-repeat="action in actions" >

                    	@{{ action.spanish_name }}

                    </th>
                </tr>
            </thead>
            <tbody>

            	<tr ng-repeat="entity in entities" style="vertical-align: top; ">

            		<th>

            			@{{ entity.spanish_name }}

            		</th>
            		<td ng-repeat="action in actions" class="text-center" > 

            			<input type="checkbox" name="Permission[@{{action.id}}][@{{entity.id}}]" ng-model="permissions[action.id][entity.id]" value="1" />

            		</td>

            	</tr>

            </tbody>
        </table>    

        <div class="form-group col-md-12 ">                                  	 
        
        	<button type="submit" class="btn btn-success pull-right">Actualizar</button>
        
        </div>
        
        {{ Form::close() }} 
        
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


    <style>
        #sortable2 { list-style-type: none; margin: 0; padding: 0; zoom: 1; }
        #sortable2 li { margin: 0 5px 5px 5px; padding: 3px; width: 90%; cursor: pointer; }
        #sortable2 li.current_level { background-color: #FF6C60; color: #FFFFFF; cursor: move; }
    </style>

    <script>
        $(function() {

            $( "#sortable2" ).sortable({
                cancel: ".ui-state-disabled"
            });

            $( "#sortable2 li" ).disableSelection();
        });
    </script>

@stop