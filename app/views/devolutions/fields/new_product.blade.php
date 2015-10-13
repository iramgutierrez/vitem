<!-- Modal -->
<div class="modal fade" id="addProduct" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Agregar nuevo producto</h4>
            </div>
            <div class="modal-body">

                {{ Form::model( new Product ,['route' => 'products.store',  'name' => 'addproductForm' , 'id' => 'addproductForm', 'method' => 'POST', 'class' => 'form-inline' ,'role' => 'form', 'novalidate' , 'enctype' =>  'multipart/form-data' , 'ng-controller' => 'AddProductController' , 'ng-init' => 'initJQuery("'.route('products.image_ajax').'"); '  ]) }}


                <div class="form-group col-md-6 col-sm-12">

                    {{ Field::text(
                    'name',
                    '' ,
                    [
                        'class' => 'col-md-12' ,
                        'placeholder' => 'Ingresa el nombre del producto'
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
                <div class="form-group col-md-6 col-sm-12" >

                    <button type="button"  id="imageProduct" >Subir imagen</button>
                    <div class="image" ></div>
                    {{ Field::hidden(
                           'image',
                           null,
                           [
                               'class' => 'col-md-12 imageProductInput' ,
                           ]
                           )
                      }}
                </div>
                <div class="form-group col-md-6 col-sm-12" >

                    {{ Field::textarea(
                    'description',
                    '' ,
                    [
                    'class' => 'col-md-12' ,
                    'placeholder' => 'Ingresa la descripción'
                    ]
                    )
                   }}
                </div>

                <div class="form-group col-md-6 col-sm-12" >

                    {{ Field::text(
                    'model',
                    '' ,
                    [
                    'class' => 'col-md-12' ,
                    'placeholder' => 'Ingresa el modelo'
                    ]
                    )
                   }}
                </div>
                {{-- <div class="form-group col-md-6 col-sm-12">

                    {{ Field::number(
                          'stock',
                          1 ,

                          [
                            'min' => 1 ,
                            'ng-model' => 'stock',
                            'ng-init' => 'stock = 1'
                          ]
                        )
                    }}

                </div>
                <div class="form-group col-md-6 col-sm-12">
                    @include('products/fields/colors')
                </div>--}}
                <div class="form-group col-md-6 col-sm-12">

                    {{ Field::text(
                      'cost',
                      null ,
                      [
                      'class' => 'col-md-12' ,
                      'placeholder' => 'Ingresa el costo',
                      'ng-model' => 'cost',
                      'ng-change' => 'calculatePrice()',
                      'addon-first' => '$' ,
                      'ng-init' => 'cost = "'.Input::old('cost').'"'
                      ]
                      )
                    }}
                </div>

                <div class="form-group col-md-6 col-sm-12" >

                    {{ Field::text(
                'percent_gain',
                null ,
                [
                'class' => 'col-md-12' ,
                'placeholder' => 'Porcentaje de ganancia',
                'ng-model' => 'percent_gain',
                'ng-change' => 'calculatePrice()',
                'addon-last' => '%' ,
                'ng-init' => 'percent_gain = "'.Input::old('percent_gain').'"'
                ]
                )
               }}
                </div>

                <div class="form-group col-md-6 col-sm-12" >
                    <?php echo  Field::checkbox(
                            'suggested_price_active',
                            null,
                            [
                                    'ng-model' => 'suggested_price_active',
                                    'ng-true-value' => "1",
                                    'ng-false-value' => "0",
                                    'ng-init' => "suggested_price_active = 0; calculatePrice();",
                                    'ng-change' => 'assignSuggestedPrice()'
                            ] ,
                            [
                                    'label-value' => '{{ suggested_price }}',
                    ]
                    )
                    ?>
                </div>

                <div class="form-group col-md-6 col-sm-12" >

                    {{ Field::text(
                'price',
                null ,
                [
                    'class' => 'col-md-12' ,
                    'placeholder' => 'Ingresa el precio',
                    'ng-model' => 'price',
                    'addon-first' => '$' ,
                    'ng-init' => 'price = "'.Input::old('price').'"'
                ]
                )
               }}
                </div>
                <div class="form-group col-md-6 col-sm-12" >

                    {{ Field::text(
                    'production_days',
                    '' ,
                    [
                        'class' => 'col-md-12' ,
                        'placeholder' => 'Ingresa los días de producción'
                    ]
                    )
                   }}
                </div>
                {{ Field::hidden(
                    'supplier_id',
                    '' ,
                    [
                        'ng-model' => '$root.supplier_id',
                        'ng-value' => '$root.supplier_id'
                    ]
                    )
               }}
                {{ Field::hidden(
                    'status',
                    '' ,
                    [
                        'ng-model' => '$root.status',
                        'ng-value' => '$root.status'
                    ]
                    )
               }}
                <div class="form-group col-md-12 ">
                    <button data-dismiss="modal" class="btn btn-default close_modal" type="button">Cerrar</button>
                    <button type="submit" class="btn btn-success pull-right" >Registrar</button>
                </div>
                {{ Form::close() }}

            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
<!-- modal -->

