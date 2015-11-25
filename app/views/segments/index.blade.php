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
    <div   ng-app="segments" >
        <div class="adv-table" ng-controller="SegmentsController" ng-init="$root.generateAuthPermissions({{ Auth::user()->role_id }})" >
            <div class="panel">
                <div class="panel-body">
                    <div ng-view></div>
                    <header class="panel-heading col-sm-12">
                        <button ng-show="$root.auth_permissions.create.segment" ng-click="newSegment()" type="button" class="pull-right btn btn-success ">Agregar criterios de segmentación</button>
                        <h1 class="col-sm-12">Criterios de segmentación</h1>
                    </header>

                    <div ng-show="new">

                        {{ Form::model( new Segment,['route' => 'segments.store',  'name' => 'addsegmentForm' , 'method' => 'POST', 'class' => 'form-inline' ,'role' => 'form', 'novalidate' , 'ng-submit' => 'addSegment($event , addsegmentForm.$valid)', 'enctype' =>  'multipart/form-data' ]) }}

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

                        <div class="col-sm-12">

                            <div class=" form-group col-md-6 col-sm-12">

                                {{ Field::text(
                                        'name',
                                        '' ,
                                        [
                                            'class' => 'col-md-12' ,
                                            'ng-model' => 'name'

                                        ]
                                    )
                                }}



                            </div>

                            <div class="col-md-6 col-sm-12">

                                <table class="display table table-bordered table-striped col-sm-12">
                                    <tbody>
                                        <tr ng-repeat="(i , item) in CatalogItem">
                                            <td class="col-sm-5">@{{ item.catalog.name }}</td>
                                            <td class="col-sm-5">
                                                @{{ item.item.name }}
                                                <input type="hidden" name="CatalogItem[]" ng-model="item.item.id" ng-value="item.item.id" />
                                            </td>
                                            <td class="col-sm-2 text-center">
                                                <a href="" ng-click="removeCatalogItem(i,item)">
                                                    <span class="badge bg-important">
                                                        <i class="fa fa-times"></i>
                                                    </span>
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                                <div class=" form-group col-md-6 col-sm-12">
                                    {{ Field::select(
                                           'catalog',
                                           [],
                                           '' ,
                                           [
                                               'ng-model' => 'catalog',
                                               'ng-options' => 'c as c.name for c in catalogs',
                                               'ng-change' => 'getCatalogItems()'

                                           ]
                                       )
                                    }}
                                </div>

                                <div class=" form-group col-md-6 col-sm-12">
                                    {{ Field::select(
                                           'catalog_item',
                                           [],
                                           '' ,
                                           [
                                               'ng-model' => 'item',
                                               'ng-options' => 'i as i.name for i in items'

                                           ]
                                       )
                                    }}
                                </div>

                                <button type="submit" class="btn btn-success pull-right" ng-click="addCatalogItem()" ng-disabled="!item || !catalog">Agregar</button>

                            </div>

                        </div>



                        <div class=" form-group col-sm-6">

                            <div ng-show="addsegmentForm.submitted || addsegmentForm.name.$touched">

                                <label for="name" class="error" ng-show="addsegmentForm.name.$error.required">

                                    Debes ingresar un nombre.

                                </label>

                            </div>

                        </div>

                        <div class="form-group col-sm-3 col-sm-offset-9 text-right">

                            <button type="button" class="btn btn-danger" ng-click="new = false">Cancelar</button>

                            <button type="submit" class="btn btn-success" data-ng-disabled="!CatalogItem.length">@{{ button }}</button>

                        </div>

                        {{ Form::close() }}


                    </div>

                    <div class="clearfix"></div>
                    <div class="col-sm-12">
                        <p class="col-sm-2"><span class="badge bg-success">@{{segments.length}}</span> criterios de segmentación</p>
                    </div>
                    <div class="clearfix"></div>
                    <div class="alert alert-block alert-warning" data-ng-show="message">
                        <button data-dismiss="alert" class="close close-sm" type="button">
                            <i class="fa fa-times"></i>
                        </button>
                        @{{ message }}
                    </div>
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
                            <th class="col-sm-3">Segmentos</th>
                            <th class="col-sm-3"></th>
                        </thead>
                        <tbody >
                        <tr class="gradeX" ng-repeat="(k,segment) in segments | orderBy:sort:reverse">
                            <td>@{{ segment.id }}</td>
                            <td>@{{ segment.name }}</td>
                            <td>
                                <ul>
                                    <li data-ng-repeat="item in segment.catalog_items">
                                        <strong>@{{ item.catalog.name }}</strong> - @{{ item.name }}
                                    </li>
                                </ul>
                            </td>
                            <td>
                                <a ng-click="updateSegment(k , segment)" ng-if="$root.auth_permissions.update.segment" >
                                    <button  type="button" class="col-sm-3 col-sm-offset-1 btn btn-info "><i class="fa fa-refresh"></i></button>
                                </a>
                                <a data-toggle="modal" href="#myModal@{{segment.id}}" ng-if="$root.auth_permissions.delete.segment">
                                    <button type="button" class="col-sm-3 col-sm-offset-1 btn btn-danger"><i class="fa fa-trash-o"></i></button>
                                </a>
                                <div ng-if="$root.auth_permissions.delete.segment" class="modal fade" id="myModal@{{segment.id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                    <h4 class="modal-title">Confirma</h4>
                                            </div>
                                            <div class="modal-body">

                                                ¿Deseas eliminar el criterio de segmentación con id <strong>@{{segment.id}}</strong>?

                                            </div>
                                            <div class="modal-footer">
                                                <button data-dismiss="modal" class="btn btn-default" type="button">Regresar</button>
                                                <form class="btn " method="POST" action = "@{{ segment.url_delete }}">
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
                    <h3 class="text-center">No se encontraron criterios de segmentación.</h3>
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
                                'library/js/ng/segments.js',
                                'library/js/ng/segments.controllers.js',
                                'library/js/ng/segments.services.js',
                                'library/js/ng/catalogs.services.js',
                                'library/js/jquery-ui-1.9.2.custom.min.js'
    							]
    				   ]
    		)

@stop