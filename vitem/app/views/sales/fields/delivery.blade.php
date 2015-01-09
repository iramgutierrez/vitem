<ul class="nav nav-tabs"> 
  <li ng-class="{active: delivery_tab == 1 }"> 
    <a href="" ng-click="delivery_tab = 1" >
      Agregar entrega
    </a> 
  </li> 
  <li ng-class="{active: delivery_tab == 2 }"> 
    <a href="" ng-click="delivery_tab = 2" >
      Dejar entrega pendiente
    </a> 
  </li> 
  <li ng-class="{active: delivery_tab == 3 }"> 
    <a href="" ng-click="delivery_tab = 3" >
      No agregar entrega
    </a> 
  </li> 
</ul>
{{ Field::hidden

    (

      'delivery_type', 

      null,

      [ 
                'ng-model' => 'delivery_tab',
                'ng-value' =>'delivery_tab'
      ]

    ) 

  }}  
<div ng-show="delivery_tab == 1">
  
    <div class="panel">

        <header class="panel-heading">

          <h1>Entrega</h1>

        </header>

        <div class="panel-body" >   

            <div class="form-group col-md-12 col-sm-12 " >

              @include('sales/fields/delivery/delivery_date')

            </div>

            <div class="form-group col-md-12 col-sm-12 " >

              @include('sales/fields/delivery/address')

            </div>

            <div class="form-group col-md-12 col-sm-12 " >

              @include('sales/fields/delivery/destination')

            </div>

            <span class="col-md-12 col-sm-12 text-center">ó</span>
              
            <div class="form-group col-md-12 col-sm-12">

              @include('sales/fields/delivery/new_destination')              
              

            </div> 

            <div ng-if="newDestination">

              @include('sales/fields/delivery/new_destination_form') 
              
            </div>

            <div class="form-group col-md-12 col-sm-12 " >

              @include('sales/fields/delivery/employee_id')

            </div>   

          <div ng-show="deliveryExists">

            <br><br>
            
            <h4 class="text-center"> @{{ deliveryExists }} </h4>
          </div>

      </div>

    </div> 

</div>