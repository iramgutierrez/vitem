@extends('layout')

@section('header')

    @include('header' , [ 'css' => [
    'library/assets/bootstrap-fileupload/bootstrap-fileupload.css',
    'library/assets/dropzone/css/dropzone.css'
    ]
    ]
    )

@stop

@section('sidebar_left')

    @include('sidebar_left')

@stop

@section('content')

    <div ng-app="devolutions">

        {{ Form::model( new Devolution ,['route' => 'devolutions.store',  'name' => 'adddevolutionForm' , 'method' => 'POST', 'class' => 'form-inline' ,'role' => 'form', 'novalidate' , 'enctype' =>  'multipart/form-data' , 'ng-controller' => 'FormController'  , 'ng-init' => '$root.generateAuthPermissions('.Auth::user()->role_id.')']) }}

        <div class="panel">

            <header class="panel-heading">

                <h1>Nueva devolución</h1>

            </header>

            <div class="panel-body" >

                <div class="form-group col-md-6 col-sm-6" >

                    @include('devolutions/fields/devolution_date')

                </div>

                <div class="form-group col-md-6 col-sm-6" >

                    @include('devolutions/fields/status_pay')

                </div>

                <div class="form-group col-md-12 col-sm-12 " >

                    @include('devolutions/fields/supplier_id')

                </div>

                <div class="form-group col-md-12 col-sm-12 " >

                    @include('devolutions/fields/products_devolution')

                    @if($errors->first('ProductDevolution'))

                        <div class="form-group col-md-12 col-sm-12 " >

                            <p class="error_message">{{ $errors->first('ProductDevolution') }}</p>

                        </div>

                    @endif

                </div>

                <div class="col-md-12 col-sm-12 " >

                    @include('devolutions/fields/table_products')

                </div>

                <div class="form-group col-md-12 ">

                    <button type="submit" class="btn btn-success pull-right">Registrar</button>

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
            'library/js/ng/devolutions.js',
            'library/js/ng/devolutions.controllers.js',
            'library/js/ng/devolutions.services.js',
            'library/js/ng/products.services.js',
            'library/js/ng/suppliers.services.js',
            'library/js/ng/users.filters.js',
            'library/js/ng/directives.js',
            'library/js/jquery-ui-1.9.2.custom.min.js' ,
            'library/assets/bootstrap-fileupload/bootstrap-fileupload.js',


            /*new product */
            'library/js/ng/products.filters.js',
            'library/js/ng/products.services.js',
            'library/js/ng/suppliers.services.js',
            'library/js/ng/colors.services.js',
            'library/assets/dropzone/dropzone.js',
            'library/js/jquery.validate.min.js'


            /*new product */
    ]
    ]
    )


@stop