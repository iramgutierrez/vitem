<div class="col-sm-3" >

    {{
        Form::radio(
            'delivery_tab',
            1,
            false,
            [
                'ng-model' => 'delivery_tab',
                'ng-init' => 'delivery_tab = checkValuePreOrOld("'.((!empty($sale->delivery_tab)) ? $sale->delivery_tab : '').'" , "'.((Input::old('delivery_tab')) ? Input::old('delivery_tab') : '').'" , "2")'

            ]
        );
    }}

    {{

        Form::label(
            'delivery_tab',
            'Agregar entrega'
        )
    }}
</div>

<div class="col-sm-3">

    {{
        Form::radio(
            'delivery_tab',
            2,
            false,
            [
                'ng-model' => 'delivery_tab'

            ]
        );
    }}

    {{

        Form::label(
            'delivery_tab',
            'Dejar entrega pendiente'
        )
    }}
</div>

<div class="col-sm-3">

    {{
        Form::radio(
            'delivery_tab',
            3,
            true,
            [
                'ng-model' => 'delivery_tab'

            ]
        );
    }}

    {{

        Form::label(
            'delivery_tab',
            'No agregar entrega'
        )
    }}
</div>
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


<div class="col-sm-12" ng-show="delivery_tab == 1">
  
    <div class="panel">



        <header class="panel-heading">

          <h1>Entrega</h1>

        </header>

        <div class="panel-body" >

            @if(isset($sale->delivery->id))

                {{ Field::text

                    (

                        'delivery.id',

                        null

                    )

                }}

            @endif

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