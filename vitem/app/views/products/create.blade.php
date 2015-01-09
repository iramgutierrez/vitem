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
<div class="panel">


  <header class="panel-heading">
    <h1>Nuevo producto</h1>
  </header>
  <div class="panel-body" ng-app="products">
    {{ Form::model( new Product ,['route' => 'products.store',  'name' => 'addproductForm' , 'method' => 'POST', 'class' => 'form-inline' ,'role' => 'form', 'novalidate' , 'enctype' =>  'multipart/form-data' , 'ng-controller' => 'FormController'  ]) }}
    <div class="form-group col-md-6 col-sm-12">

     {{ Field::text(
     'name', 
     '' , 
     [ 
     'class' => 'col-md-12' , 
     'placeholder' => 'Ingresa el nombre del producto',
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

 {{ Field::text(
 'model', 
 '' , 
 [ 
 'class' => 'col-md-12' , 
 'placeholder' => 'Ingresa el modelo',
 ]
 )
}}
</div>                               		     
<div class="form-group col-md-6 col-sm-12">

 {{ Field::text(
 'stock', 
 '' , 
 [ 
 'class' => 'col-md-12' , 
 'placeholder' => 'Ingresa la cantidad',
 ]
 )
}}
</div>                               		     
<div class="form-group col-md-6 col-sm-12">

 {{ Field::text(
 'price', 
 '' , 
 [ 
 'class' => 'col-md-12' , 
 'placeholder' => 'Ingresa el precio',
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
<div class="form-group col-md-12 col-sm-12 ">

  <?php 

     $supplierSelectedIdAttr = [ 
      'class' => 'col-md-12' , 
      'ng-model' => 'supplierSelected.id',
      'ng-value' => 'supplierSelected.id',
      'ng-if' => '!newSupplier',
    ];

    if(Session::has('supplierSelectedId'))
    {
      $supplierSelectedIdAttr['ng-init'] = 'supplierSelectedInit('.Session::get('supplierSelectedId').')';
    }   
  ?>

  {{ Field::hidden(
  'supplier_id', 
  '' , 
  $supplierSelectedIdAttr
  );
}}
<h3>Proveedor</h3>  
{{ Field::text(
  '', 
  '' , 
  [ 
  'class' => 'col-md-10' , 
  'addon-first' => '<a ng-click="newSupplier = 0" style="cursor:pointer;"><i class="fa fa-search"></i></a>' , 
  'placeholder' => 'Busca por id, nombre o correo electrónico.',
  'ng-model' => 'find',
  'ng-disabled' => 'newSupplier',
  'ng-change' => 'search()',
  'ng-focus' => 'search()',
  'ng-blur' => 'hideItems()'

  ]
  ) 
}}   
<section ng-show="autocomplete" class="panel col-sm-4">
  <ul class="list-group">
    <li ng-click="addAutocomplete(supplier)" ng-repeat="supplier in suppliers" class="list-group-item " href="#">
      @{{supplier.name}}
    </li>
  </ul>
</section>
<div class="clearfix"></div>
<div class="col-md-12 supplierSelected" ng-if="!newSupplier && find != '' ">
  <div class="panel">
    <div class="panel-body">
      <div class="media-body">
        <h4>@{{ supplierSelected.name }} <span class="text-muted small"> - @{{ supplierSelected.email }}</span></h4>
        <address>
          <strong>@{{ supplierSelected.street }} @{{ supplierSelected.outer_number }} @{{ supplierSelected.inner_number }}</strong><br>
          @{{ supplierSelected.city }}<br>
          @{{ supplierSelected.state }}<br>
          <abbr title="Phone">P:</abbr> @{{ supplierSelected.phone }}
        </address>

      </div>
    </div>
  </div>
</div>    
</div>
<span class="col-md-12 col-sm-12 text-center">ó</span>
<div class="panel"> 
 <div class="form-group col-md-12 col-sm-12 panel-heading">
   <?php 

    $newSupplierAttr = [
      'ng-model' => 'newSupplier',
      'ng-true-value' => "1",
      'ng-false-value' => "0",
      'ng-change' => 'autocomplete = 0'
    ];

    if((Session::has('newSupplier')))
    {
      $newSupplierAttr['ng-init'] = 'newSupplier = ' . Session::get('newSupplier');   
    }
    

    echo  Field::checkbox(
    '', 
    '1',
    $newSupplierAttr ,
    [
    'label-value' => 'Agrega un nuevo proveedor',
    ]                                     
    ) 
    ?>
  </div>  

  <div class="panel-body" ng-if="newSupplier">
   <div class="form-group col-md-6 col-sm-12">

     {{ Field::text(
     'supplier.name', 
     '' , 
     [ 
     'class' => 'col-md-12' , 
     'placeholder' => 'Ingresa el nombre completo',
     'required',
     'ng-model' => 'client.name'
     ]
     )
   }}
 </div>
 <div class="form-group col-md-6 col-sm-12">
   {{ Field::text(
   'supplier.email', 
   '' , 
   [ 
   'class' => 'col-md-12' , 
   'placeholder' => 'Ingresa el correo electrónico'
   ]
   ) 
 }}
</div>
<div class="form-group col-md-6 col-sm-12">
  {{ Field::text(
  'supplier.rfc', 
  '' , 
  [ 
  'class' => 'col-md-12' ,
  'placeholder' => 'Ingresa el RFC'
  ]
  ) 
}}
</div>      
<div class="form-group col-md-6 col-sm-12">
  {{ Field::text(
  'supplier.business_name', 
  '' , 
  [ 
  'class' => 'col-md-12' ,
  'placeholder' => 'Ingresa la razón social'
  ]
  ) 
}}
</div>   
<div class="form-group col-md-6 col-sm-12">
 {{ Field::text(
 'supplier.phone', 
 '' , 
 [ 
 'class' => 'col-md-12' ,
 'placeholder' => 'Ingresa el teléfono'
 ]
 ) 
}}
</div>

<div class="form-group col-md-6 col-sm-12">
  {{ Field::text(
  'supplier.street', 
  '' , 
  [ 
  'class' => 'col-md-12' ,
  'placeholder' => 'Ingresa la calle de la dirección'
  ]
  ) 
}}
</div>                                
<div class="form-group col-md-6 col-sm-12">
  {{ Field::text(
  'supplier.outer_number', 
  '' , 
  [ 
  'class' => 'col-md-12' ,
  'placeholder' => 'Ingresa el número exterior'
  ]
  ) 
}}
</div>                                
<div class="form-group col-md-6 col-sm-12">
  {{ Field::text(
  'supplier.inner_number', 
  '' , 
  [ 
  'class' => 'col-md-12' ,
  'placeholder' => 'Ingresa el número interior'
  ]
  ) 
}}
</div>                                
<div class="form-group col-md-6 col-sm-12">
  {{ Field::text(
  'supplier.zip_code', 
  '' , 
  [ 
  'class' => 'col-md-12' ,
  'placeholder' => 'Ingresa el código postal'
  ]
  ) 
}}
</div>                                
<div class="form-group col-md-6 col-sm-12">
  {{ Field::text(
  'supplier.colony', 
  '' , 
  [ 
  'class' => 'col-md-12' ,
  'placeholder' => 'Ingresa la colonia'
  ]
  ) 
}}
</div>                                
<div class="form-group col-md-6 col-sm-12">
  {{ Field::text(
  'supplier.city', 
  '' , 
  [ 
  'class' => 'col-md-12' ,
  'placeholder' => 'Ingresa la ciudad, delegación o municipio'
  ]
  ) 
}}
</div>                                
<div class="form-group col-md-6 col-sm-12">
  {{ Field::text(
  'supplier.state', 
  '' , 
  [ 
  'class' => 'col-md-12' ,
  'placeholder' => 'Ingresa el estado'
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
  'ng-init' => "status = 1"
  ] ,
  [
  'label-value' => '{{ status | boolean }}',
  ]                                     
  ) 
  ?>
</div>   
</div>          
</div>                   
<div class="form-group col-md-12 ">                                  	 
  <button type="submit" class="btn btn-success pull-right">Registrar</button>
</div>
{{ Form::close() }}
</div>
</div>

@stop

@section('sidebar_right')

@include('sidebar_right')

@stop

@section('footer')

@include('footer', ['js' => [
'library/js/ng/products.js',
'library/js/ng/products.controllers.js',
'library/js/ng/products.filters.js',
'library/js/ng/products.services.js',
'library/js/ng/suppliers.services.js',
'library/js/ng/directives.js',
'library/js/jquery-ui-1.9.2.custom.min.js' ,
'library/assets/bootstrap-fileupload/bootstrap-fileupload.js'
]
]
)

@stop