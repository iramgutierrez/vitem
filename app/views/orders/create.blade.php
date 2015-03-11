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

    <div ng-app="orders">

        {{ Form::model( new Order ,['route' => 'orders.store',  'name' => 'addorderForm' , 'method' => 'POST', 'class' => 'form-inline' ,'role' => 'form', 'novalidate' , 'enctype' =>  'multipart/form-data' , 'ng-controller' => 'FormController'  , 'ng-init' => '$root.generateAuthPermissions('.Auth::user()->role_id.')']) }}

        <div class="panel">

            <header class="panel-heading">

                <h1>Nuevo pedido</h1>

            </header>

            <div class="panel-body" >

                <div class="form-group col-md-6 col-sm-6" >

                    @include('orders/fields/order_date')

                </div>

                <div class="form-group col-md-12 col-sm-12 " >

                    @include('orders/fields/supplier_id')

                </div>

                <div ng-if="$root.auth_permissions.create.supplier" class="col-sm-4 col-md-4 col-sm-offset-8 col-md-offset-8 text-right">

                    <a data-toggle="modal" href="#addSupplier" >

                        <button type="button" class="col-sm-6 col-sm-offset-6 btn btn-danger">Crear nuevo proveedor</button>

                    </a>

                </div>               

                <div class="form-group col-md-12 col-sm-12 " >

                    @include('orders/fields/products_order')

                    @if($errors->first('ProductOrder'))

                        <div class="form-group col-md-12 col-sm-12 " >

                            <p class="error_message">{{ $errors->first('ProductOrder') }}</p>

                        </div>

                    @endif

                </div> 



                <div ng-if="$root.auth_permissions.create.product" class="col-sm-12 col-md-12 text-right">

                    <a data-toggle="modal" href="#addProduct" >

                        <button type="button" class="col-sm-2 col-sm-offset-10 btn btn-danger" ng-disabled = "!$root.supplier_id">Crear nuevo producto <br>y agregarlo a la venta</button>

                    </a>

                </div>

                <div class="col-md-12 col-sm-12 " >

                    @include('orders/fields/table_products')

                </div>

                <div class="form-group col-md-12 ">

                    <button type="submit" class="btn btn-success pull-right">Registrar</button>

                </div>


            </div>

        </div>

        {{ Form::close() }}

        <div ng-if="$root.auth_permissions.create.product" >

            @include('orders/fields/new_product')

        </div>

        <div ng-if="$root.auth_permissions.create.supplier" >

            @include('orders/fields/new_supplier')

        </div>

    </div>

@stop

@section('sidebar_right')

    @include('sidebar_right')

@stop

@section('footer')

    @include('footer', ['js' => [
            'library/js/ng/orders.js',
            'library/js/ng/orders.controllers.js',
            'library/js/ng/orders.services.js',
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
            'library/assets/dropzone/dropzone.js',
            'library/js/jquery.validate.min.js'


            /*new product */
    ]
    ]
    )


@stop