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

    <div ng-app="discounts">

        {{ Form::model( new Discount ,[
            'route' => 'discounts.store',
            'name' => 'adddiscountForm' ,
            'method' => 'POST',
            'class' => 'form-inline' ,
            'role' => 'form',
            'novalidate' ,
            'enctype' =>  'multipart/form-data' ,
            'ng-controller' => 'FormController'  ,
            'ng-init' => '$root.generateAuthPermissions('.Auth::user()->role_id.')'
        ]) }}

        <div class="panel">

            <header class="panel-heading">

                <h1>Nuevo descuento</h1>

            </header>

            <div class="panel-body" >

                <div class="form-group col-md-4 col-sm-12" >

                    @include('discounts/fields/type')

                </div>

                <div class="form-group col-md-4 col-sm-6" >

                    @include('discounts/fields/discount_type')

                </div>

                <div class="form-group col-lg-3 col-md-4 col-sm-6" >

                    @include('discounts/fields/quantity')

                </div>

                <div class="form-group col-md-6 col-sm-12" >

                    @include('discounts/fields/stores')

                </div>

                <div class="form-group col-md-6 col-sm-12" >

                    @include('discounts/fields/pay_types')

                </div>

                <div class="form-group col-sm-6" >

                    @include('discounts/fields/init_date')

                </div>

                <div class="form-group col-sm-6" >

                    @include('discounts/fields/end_date')

                </div>

                <div ng-show="type == 1">



                    <div class="col-md-8 col-sm-8 " >

                        <ul class="nav nav-tabs">

                            <li class="active">

                                <a data-toggle="tab" href="#" ng-click="tab = 'pack'">Agregar paquetes</a>

                            </li>

                            <li class="">

                                <a data-toggle="tab" href="#" ng-click="tab = 'product'" >Agregar productos</a>

                            </li>

                        </ul>

                    </div>

                    <div class="form-group col-md-12 col-sm-12 " ng-show="tab == 'product'" >

                        @include('discounts/fields/product')

                    </div>

                    <div class="form-group col-md-12 col-sm-12 " ng-show="tab == 'pack'" >

                        @include('discounts/fields/pack')

                    </div>

                    <div class="col-md-12 col-sm-12 " >

                        @include('discounts/fields/product_pack')

                    </div>

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
            'library/js/ng/discounts.js',
            'library/js/ng/discounts.controllers.js',
            'library/js/ng/discounts.services.js',
            'library/js/ng/products.services.js',
            'library/js/ng/packages.services.js',
            'library/js/ng/pay_types.services.js',
            'library/js/ng/stores.services.js',
            'library/js/ng/users.filters.js',
            'library/js/ng/directives.js',
            'library/js/jquery-ui-1.9.2.custom.min.js' ,
    ]
    ]
    )

@stop