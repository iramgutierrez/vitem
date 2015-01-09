@extends('layout')

@section('header')

@include('header' , [ 'css' => [
'library/assets/bootstrap-fileupload/bootstrap-fileupload.css'
]
]
)

@stop

@section('sidebar_left')

@include('sidebar_left')

@stop

@section('content')

<div ng-app="packages">
{{ Form::model( new Pack ,['route' => 'packs.store',  'name' => 'addpackageForm' , 'method' => 'POST', 'class' => 'form-inline' ,'role' => 'form', 'novalidate' , 'enctype' =>  'multipart/form-data' , 'ng-controller' => 'FormController'  ]) }}
<div class="panel">
  <header class="panel-heading">
    <h1>Nuevo paquete</h1>
  </header>
  <div class="panel-body" >
    
    <div class="form-group col-md-6 col-sm-12">

     {{ Field::text(
     'name', 
     '' , 
     [ 
     'class' => 'col-md-12' , 
     'placeholder' => 'Ingresa el nombre del paquete',
     ]
     )
   }}
 </div> 
 <div class="form-group col-md-6 col-sm-12">

   {{ Field::text(
   'key', 
   '' , 
   [ 
   'class' => 'col-md-12' , 
   'placeholder' => 'Ingresa el código',
   ]
   )
 }}
</div>       
<div class="form-group col-md-6 col-sm-12">
 {{ Field::image(
 'image', 
 asset('images_profile/default.jpg'),
 [ 
 'class' => 'col-md-12' , 
 ]
 ) 
}}
</div>    
<div class="form-group col-md-6 col-sm-12">

 {{ Field::textarea(
 'description', 
 '' , 
 [ 
 'class' => 'col-md-12' , 
 'placeholder' => 'Ingresa la descripción',
 ]
 )
}}
</div>       
<div class="form-group col-md-6 col-sm-12">
 <?php echo  Field::checkbox(
  'status', 
  '1',
  [
  'ng-model' => 'status',
  'ng-true-value' => "1",
  'ng-false-value' => "0",
  'ng-init' => "status = 0"
  ] ,
  [
  'label-value' => '{{ status | booleanProduct }}',
  ]                                     
  ) 
  ?>
</div>  
</div>
</div> 
@if($errors->first('PackProducts'))

  <p class="error_message">{{ $errors->first('PackProducts') }}</p>

@endif
<div class="productsPackage"  >

  <div class="panel">

    <div class="panel-body">

      <div class="form-group col-md-12 col-sm-12 " >

        @include('packs/fields/products_pack')

      </div> 

      <div class="col-md-12 col-sm-12 " >

        @include('packs/fields/table_products')

      </div>
   
    </div>

  </div>
	
</div>

<div class="panel">
  <div class="panel-body">                 
    {{-- <div class="form-group col-md-12 ">         
      <button type="button" ng-click="addProduct()" class="btn btn-info">Agregar producto</button>    
    </div> --}}
    <div class="form-group col-md-6 col-sm-12">

     {{ Field::text(
     'price', 
     '' , 
     [ 
     'class' => 'col-md-12' , 
     'placeholder' => 'Ingresa el precio',
     'ng-model' => 'price'
     ]
     )
    }}
    </div>                                       
    <div class="form-group col-md-6 col-sm-12">

     {{ Field::text(
     'cost', 
     '' , 
     [ 
     'class' => 'col-md-12' , 
     'placeholder' => 'Ingresa el costo',
     'ng-model' => 'cost'
     ]
     )
    }}
    </div>   
    <div class="form-group col-md-6 col-sm-12">

     {{ Field::text(
     'production_days', 
     '' , 
     [ 
     'class' => 'col-md-12' , 
     'placeholder' => 'Ingresa los días de producción',
     'ng-model' => 'production_days'
     ]
     )
    }}
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
'library/js/ng/packages.js',
'library/js/ng/packages.controllers.js',
'library/js/ng/packages.filters.js',
'library/js/ng/packages.services.js',
'library/js/ng/products.services.js',
'library/js/ng/directives.js',
'library/js/jquery-ui-1.9.2.custom.min.js' ,
'library/assets/bootstrap-fileupload/bootstrap-fileupload.js'
]
]
)

@stop