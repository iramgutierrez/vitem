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
    <div   ng-app="catalogs" >
        <div class="adv-table" ng-controller="CatalogsController" ng-init="$root.generateAuthPermissions({{ Auth::user()->role_id }})" >
            <div class="panel">
                <div class="panel-body">
                    <div ng-view></div>
                    <header class="panel-heading col-sm-12">
                        <button ng-show="$root.auth_permissions.create.catalog" ng-click="newCatalog()" type="button" class="pull-right btn btn-success ">Agregar catálogo</button>
                        <h1 class="col-sm-12">Catálogos</h1>
                    </header>

                    <div ng-show="new">

                        {{ Form::model( new Catalog,['route' => 'catalogs.store',  'name' => 'addcatalogForm' , 'method' => 'POST', 'class' => 'form-inline' ,'role' => 'form', 'novalidate' , 'ng-submit' => 'addCatalog($event , addcatalogForm.$valid)', 'enctype' =>  'multipart/form-data' ]) }}

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

                            <div ng-show="addcatalogForm.submitted || addcatalogForm.name.$touched">

                                <label for="name" class="error" ng-show="addcatalogForm.name.$error.required">

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
                        <p class="col-sm-2"><span class="badge bg-success">@{{catalogs.length}}</span> catálogos</p>
                    </div>
                    <div class="clearfix"></div>
                    <hr>
                    <table  class="display table table-bordered table-striped col-sm-12" id="dynamic-table" >
                        <thead>
                        <tr >
                            <th class="col-sm-2">
                                <a href="" ng-click="sort = 'id'; reverse=!reverse">Id
                            <span class="pull-right" >
                                <i class="fa fa-sort" ng-if="sort != 'id' "></i>
                                <i class="fa fa-sort-alpha-asc" ng-if=" sort == 'id' && reverse == false "></i>
                                <i class="fa  fa-sort-alpha-desc" ng-if=" sort == 'id' && reverse == true "></i>
                            </span>
                                </a>
                            </th>
                            <th class="col-sm-2">
                                <a href="" ng-click="sort = 'name'; reverse=!reverse">Nombre
                            <span class="pull-right" >
                                <i class="fa fa-sort" ng-if="sort != 'name' "></i>
                                <i class="fa fa-sort-alpha-asc" ng-if=" sort == 'name' && reverse == false "></i>
                                <i class="fa  fa-sort-alpha-desc" ng-if=" sort == 'name' && reverse == true "></i>
                            </span>
                                </a>
                            </th>
                            <th class="col-sm-2">Elementos</th>
                            <th class="col-sm-2"></th>
                            <th class="col-sm-2"></th>
                        </thead>
                        <tbody >
                        <tr class="gradeX" ng-repeat="(k,catalog) in catalogs | orderBy:sort:reverse">
                            <td>@{{ catalog.id }}</td>
                            <td>@{{ catalog.name }}</td>
                            <td>
                                <ul>
                                    <li ng-repeat="item in catalog.items">
                                        @{{ item.name }}
                                        <span class="pull-right">
                                            <a data-toggle="modal" href="#updateItems" ng-click="setItem(item , catalog)">Editar</a>
                                            <a data-toggle="modal" href="#deleteItems" ng-click="setItem(item , catalog)">Borrar</a>
                                        </span>

                                    </li>
                                </ul>
                                <div ng-if="$root.auth_permissions.update.catalog" class="modal fade" id="updateItems" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <form class="" method="POST" action = "{{ route('catalog_items.store') }}">

                                            <div class="modal-content">

                                                {{  Form::token() }}
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                    <h4 class="modal-title">Editar elemento al catálogo de @{{ catalog_name }}</h4>
                                                </div>
                                                <div class="modal-body">

                                                    <input type="hidden" name="catalog_id" ng-model="catalog_id" ng-value="catalog_id"/>

                                                    <input type="hidden" name="id" ng-model="item_id" ng-value="item_id"/>

                                                    {{ Field::text

                                                        (

                                                            'name',

                                                            null ,

                                                            [
                                                                'ng-model' => 'item_name'
                                                            ]

                                                        )

                                                    }}

                                                </div>
                                                <div class="modal-footer">
                                                    <button data-dismiss="modal" class="btn btn-default" type="button">Regresar</button>

                                                    <button type="submit" class="btn btn-success">Editar</button>
                                                </div>

                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div ng-if="$root.auth_permissions.delete.catalog" class="modal fade" id="deleteItems" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <form class="" method="POST" action = "{{ route('catalog_items.store') }}">

                                            <div class="modal-content">

                                                {{  Form::token() }}
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                    <h4 class="modal-title">Eliminar elemento al catálogo de @{{ catalog_name }}</h4>
                                                </div>
                                                <div class="modal-body">

                                                    <input type="hidden" name="id" ng-model="item_id" ng-value="item_id"/>

                                                    <input type="hidden" name="delete" value="1" />

                                                    ¿Deseas eliminar el elemento <strong>@{{ item_name }}</strong> del catálogo <strong>@{{ catalog_name }}</strong>?

                                                </div>
                                                <div class="modal-footer">
                                                    <button data-dismiss="modal" class="btn btn-default" type="button">Regresar</button>

                                                    <button type="submit" class="btn btn-success">Eliminar</button>
                                                </div>

                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </td>
                            <td>

                                <a data-toggle="modal" href="#addItems@{{catalog.id}}" ng-if="$root.auth_permissions.create.catalog">
                                    <button type="button" class="col-sm-10 col-sm-offset-1 btn btn-success">Agregar elementos</button>
                                </a>
                                <div ng-if="$root.auth_permissions.create.catalog" class="modal fade" id="addItems@{{catalog.id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <form class="" method="POST" action = "{{ route('catalog_items.store') }}">

                                            <div class="modal-content">

                                                {{  Form::token() }}
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                    <h4 class="modal-title">Agregar elemento al catálogo de @{{ catalog.name }}</h4>
                                                </div>
                                                <div class="modal-body">

                                                    <input type="hidden" name="catalog_id" ng-model="catalog.id" ng-value="catalog.id"/>

                                                    {{ Field::text

                                                        (

                                                            'name',

                                                            null ,

                                                            []

                                                        )

                                                    }}

                                                </div>
                                                <div class="modal-footer">
                                                    <button data-dismiss="modal" class="btn btn-default" type="button">Regresar</button>

                                                    <button type="submit" class="btn btn-success">Agregar</button>
                                                </div>

                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <a ng-click="updateCatalog(k , catalog)" ng-if="$root.auth_permissions.update.catalog" >
                                    <button  type="button" class="col-sm-3 col-sm-offset-1 btn btn-info "><i class="fa fa-refresh"></i></button>
                                </a>
                                <a data-toggle="modal" href="#myModal@{{catalog.id}}" ng-if="$root.auth_permissions.delete.catalog">
                                    <button type="button" class="col-sm-3 col-sm-offset-1 btn btn-danger"><i class="fa fa-trash-o"></i></button>
                                </a>
                                <div ng-if="$root.auth_permissions.delete.catalog" class="modal fade" id="myModal@{{catalog.id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                <h4 class="modal-title">Confirma</h4>
                                            </div>
                                            <div class="modal-body">

                                                ¿Deseas eliminar el catálogo de <strong>@{{catalog.name}}</strong>?

                                            </div>
                                            <div class="modal-footer">
                                                <button data-dismiss="modal" class="btn btn-default" type="button">Regresar</button>
                                                <form class="btn " method="POST" action = "@{{ catalog.url_delete }}">
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
                    <h3 class="text-center">No se encontraron catálogos.</h3>
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
                                'library/js/ng/catalogs.js',
                                'library/js/ng/catalogs.controllers.js',
                                'library/js/ng/catalogs.services.js',
                                'library/js/jquery-ui-1.9.2.custom.min.js'
    							]
    				   ]
    		)

@stop