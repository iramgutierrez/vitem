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
{{ Form::model( $pack ,['route' => ['packs.update', $pack->id],  'name' => 'addpackageForm' , 'method' => 'PATCH', 'class' => 'form-inline' ,'role' => 'form', 'novalidate' , 'enctype' =>  'multipart/form-data' , 'ng-controller' => 'FormController'  , 'ng-init' => '$root.generateAuthPermissions('.\Auth::user()->role_id.')'   ]) }}
<div class="panel">
  <header class="panel-heading">
    <h1>Editar paquete</h1>
  </header>
  <div class="panel-body" >
    
    <div class="form-group col-md-6 col-sm-12">

     {{ Field::text(
     'name', 
     null , 
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
   null , 
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
 asset('images_packs/').'/'.(!empty($pack->image) ? $pack->image : 'default.jpg') ,
 [ 
 'class' => 'col-md-12' , 
 ]
 ) 
}}
</div>    
<div class="form-group col-md-6 col-sm-12">

 {{ Field::textarea(
   'description', 
   null , 
   [ 
   'class' => 'col-md-12' , 
   'placeholder' => 'Ingresa la descripción',
   ]
 )
}}
</div>    
</div>
</div> 
@if($errors->first('PackProducts'))

  <p class="error_message">{{ $errors->first('PackProducts') }}</p>

@endif
<div class="productsPackage"  >

  <div class="panel">

    <div class="panel-body">

        <div ng-if="$root.auth_permissions.create.product" class="col-sm-4 col-md-4 text-right col-md-offset-8 col-sm-offset-8">

            <a data-toggle="modal" href="#addProduct" >

                <button type="button" class="col-sm-6 col-sm-offset-6 btn btn-danger">Crear nuevo producto</button>

            </a>

        </div>

      <div class="form-group col-md-12 col-sm-12 " >

        @include('packs/fields/products_pack')

      </div> 

      <div class="col-md-12 col-sm-12 " >

        @include('packs/fields/table_products_edit')

      </div>
   
    </div>

  </div>
  
</div>

<div class="panel">
  <div class="panel-body">                 
   
    <div class="form-group col-md-12 ">                              
      <button type="submit" class="btn btn-success pull-right">Actualizar</button>
    </div>
  </div>
</div>

{{ Form::close() }}

    @include('packs/fields/new_product')

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