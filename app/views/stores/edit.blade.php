@extends('layout')

@section('header')

    @include('header' , [ 'css' => [
    ]
    ]
    )

@stop

@section('sidebar_left')

    @include('sidebar_left')

@stop

@section('content')

    <div ng-app="stores">

        {{ Form::model( $store ,['route' => ['stores.update' , $store->id],  'name' => 'addstoreForm' , 'method' => 'PATCH', 'class' => 'form-inline' ,'role' => 'form', 'novalidate' , 'enctype' =>  'multipart/form-data' , 'ng-controller' => 'FormController' , 'ng-init' => '$root.generateAuthPermissions('.Auth::user()->role_id.')'  ]) }}

        <div class="panel">

            <header class="panel-heading">

                <h1>Nueva sucursal</h1>

            </header>

            <div class="panel-body" >

                <div class="form-group col-md-6 col-sm-6" >

                    @include('stores/fields/name')

                </div>

                <div class="form-group col-md-6 col-sm-6" >

                    @include('stores/fields/email')

                </div>

                <div class="form-group col-md-6 col-sm-6" >

                    @include('stores/fields/address')

                </div>

                <div class="form-group col-md-6 col-sm-6" >

                    @include('stores/fields/phone')

                </div>

                <div class="form-group col-md-12 ">

                    <button type="submit" class="btn btn-success pull-right">Actualizar</button>

                </div>


            </div>

        </div>

        {{ Form::close() }}

    </div>

@stop

@section('sidebar_right')

    @include('sidebar_right')

@stop

@section('footer')

    @include('footer', ['js' => [
            'library/js/ng/stores.js',
            'library/js/ng/stores.controllers.js',
            'library/js/ng/stores.services.js',
            'library/js/ng/users.filters.js',
            'library/js/ng/directives.js',
            'library/js/jquery-ui-1.9.2.custom.min.js' ,
            'library/assets/bootstrap-fileupload/bootstrap-fileupload.js',
    ]
    ]
    )


@stop